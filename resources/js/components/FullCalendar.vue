<template>
    <div>
        <FullCalendar :options="calendarOptions" :event-content="eventContent"/>
    </div>
</template>

<script setup>
import {ref, watchEffect} from 'vue';
import FullCalendar from '@fullcalendar/vue3'
import dayGridPlugin from '@fullcalendar/daygrid'
import timeGridPlugin from '@fullcalendar/timegrid'
import interactionPlugin from '@fullcalendar/interaction'
import bootstrap5Plugin from '@fullcalendar/bootstrap5'

const props = defineProps({
    events: {
        type: Array,
        default: [],
    },
    handleSelect: Function,
})

const calendarOptions = ref({
    plugins: [dayGridPlugin, interactionPlugin, bootstrap5Plugin, timeGridPlugin],
    themeSystem: 'bootstrap5',
    initialView: 'dayGridMonth',
    events: [],
    locale: 'hu',
    headerToolbar: {
        left: 'prev,next,today',
        center: 'title',
        right: 'dayGridMonth,timeGridWeek,timeGridDay'
    },
    selectable: true,
    selectOverlap: true,
    select: (selectionInfo) => props.handleSelect(selectionInfo),
});

watchEffect(() => {
    calendarOptions.value.events = props.events;
});
</script>
