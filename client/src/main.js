import { createApp } from 'vue'
import './style.css'
import App from './App.vue'
import router from './router/router';
import PrimeVue from 'primevue/config';
import Aura from '@primevue/themes/aura';
import { createPinia } from 'pinia'
import VueApexCharts from "vue3-apexcharts";

const app = createApp(App);
const pinia = createPinia();

// app.use calls
app.use(pinia);
app.use(router);
app.use(PrimeVue, {
    theme: {
        preset: Aura,
        options: {
            prefix: 'p',
            darkModeSelector: 'system',
            cssLayer: false
        }
    },
 });
 app.use(VueApexCharts);


app.mount('#app');
