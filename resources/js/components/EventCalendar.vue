<template>
    <div class="row">
        <div class="col-12">
            <FullCalendar :events="events" :handleSelect="handleSelect"/>
        </div>
    </div>
</template>

<script setup>
import FullCalendar from "./FullCalendar.vue"
import {onMounted, ref} from "vue";

const events = ref([])

async function fetchEvents() {
    try {
        const response = await axios.get('/events')
        events.value = response.data.data.map((event) => getEventObject(event))
    } catch (error) {
        alert('Error, could not fetch data')
    }
}

async function storeEvent(data) {
    try {
        const response = await axios.post('/events', data)
        events.value.push(getEventObject(response.data.data))
    } catch (error) {
        alert('A foglalás sikertelen! Válassz másik időpontot, vagy próbáld újra később.')
    }
}

function getEventObject(event) {
    return {
        start: event.start_time,
        end: event.end_time,
        title: event.title,
        display: isBackgroundEvent(event.type) ? 'background' : 'block'
    }
}

function isBackgroundEvent(type) {
    return 'background' === type
}

async function handleSelect(selectionInfo) {
    if (!isValidView(selectionInfo.view.type)) {
        return
    }

    const userName = window.prompt('Add meg a vendég nevét!')
    const data = {
        title: userName,
        time_range: {
            start: selectionInfo.startStr,
            end: selectionInfo.endStr,
        }
    }
    await storeEvent(data)
}

function isValidView(viewType) {
    const validViewTypes = ['timeGridWeek', 'timeGridDay']
    return validViewTypes.includes(viewType)
}

onMounted(async () => {
    await fetchEvents()
})
</script>
