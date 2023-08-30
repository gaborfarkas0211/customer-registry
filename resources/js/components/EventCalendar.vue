<template>
    <div class="row">
        <div class="col-12">
            <FullCalendar :events="events"/>
        </div>
    </div>
</template>

<script setup>
import FullCalendar from "./FullCalendar.vue"
import {onMounted, ref} from "vue";

const events = ref([])

const fetchEvents = async () => {
    try {
        const response = await axios.get('/events')
        events.value = response.data
    } catch (error) {
        alert('Error, could not fetch data')
    }
}

onMounted(async () => {
    await fetchEvents();
})
</script>
