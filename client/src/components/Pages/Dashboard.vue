<template>
    <AuthenticatedPage :pageTitle="'Supply Dashboard'">
      <div class="w-full flex flex-col min-h-[94%] h-[94%] justify-start items-start font-lexend gap-4 text-black">
        <!-- <FullCalendar :options="calendarOptions" class="w-full h-full bg-gray-200 font-lexend font-light p-4 shadow-md shadow-slate-600"/> -->
         <OfficeSelection v-model:visible="officeSelection" v-model="selectedOffices"/>
         {{ selectedOffices }}
      </div>
    </AuthenticatedPage>

  </template>

<script setup>
    import { ref, onMounted, computed } from 'vue';
    import AuthenticatedPage from '../PageLayouts/AuthenticatedPage.vue';
    import axios from '../../axios/axios.js';
    import { useAuthStore } from '../../stores/authStore.js';
    import VueApexCharts from 'vue3-apexcharts';
    import Dialog from 'primevue/dialog';
    import OfficeSelection from '../selections/OfficeSelection.vue';

    import FullCalendar from '@fullcalendar/vue3'
    import dayGridPlugin from '@fullcalendar/daygrid'
    import interactionPlugin from '@fullcalendar/interaction'

    var officeSelection = ref(true);
    var selectedOffices = ref([]);

    const calendarOptions =  {
        plugins: [ dayGridPlugin, interactionPlugin ],
        initialView: 'dayGridMonth',
        weekends: false,
         themeSystem: 'bootstrap5',
        dateClick: () => {
            console.log('date click!');
        },
        eventClick: (info) => {
            console.log(info);
        },
        events: [
          {  
            start: '2025-05-07T10:00:00',
            end: '2025-05-07T11:30:00',
            title: 'Meeting', 
            extendedProps: {
                description: 'Discuss project progress and next steps.',
                location: 'Conference Room A',
                attendees: ['Alice', 'Bob', 'John']
            }
        },
          { title: 'Event', date: '2025-05-02' },
          { title: 'Event', date: '2025-05-02' },
          { title: 'Event', date: '2025-05-02' },
        ]
      }

    onMounted(() => {
       
    });



</script>