<template>
    <div>
        <FullCalendar :options="calendarOptions"/>
    </div>
</template>

<script setup>
import {ref, watchEffect} from 'vue';
import FullCalendar from '@fullcalendar/vue3'
import dayGridPlugin from '@fullcalendar/daygrid'
import interactionPlugin from '@fullcalendar/interaction'
import bootstrap5Plugin from '@fullcalendar/bootstrap5'

const props = defineProps({
    events: {
        type: Array,
        default: [],
    }
})
const calendarOptions = ref({
    plugins: [dayGridPlugin, interactionPlugin, bootstrap5Plugin],
    themeSystem: 'bootstrap5',
    initialView: 'dayGridMonth',
    events: [],
    locale: 'hu',
    headerToolbar: {
        left: 'prev,next,today',
        center: 'title',
        right: 'dayGridMonth,dayGridWeek,dayGridDay'
    },
});

watchEffect(() => {
    calendarOptions.value.events = props.events;
});
</script>
