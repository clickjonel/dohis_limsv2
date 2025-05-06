import { createApp } from 'vue'
import './style.css'
import App from './App.vue'
import router from './router/router';
import PrimeVue from 'primevue/config';
import Aura from '@primevue/themes/aura'
import Nora from '@primevue/themes/nora';
import { createPinia } from 'pinia'
import VueApexCharts from "vue3-apexcharts";

const app = createApp(App);
const pinia = createPinia();

// app.use calls
app.use(pinia);
app.use(router);
app.use(PrimeVue, {
    theme: {
        preset: Nora,
        options: {
            prefix: 'p',
            darkModeSelector: false,
            cssLayer: false
        }
    },
 });
 app.use(VueApexCharts);


app.mount('#app');

document.title = import.meta.env.VITE_APP_NAME;