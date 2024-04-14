import './bootstrap';
import '../css/app.css';

import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/inertia-vue3'
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { ZiggyVue } from '../../vendor/tightenco/ziggy/dist/vue.m';

// primve vue
import PrimeVue from 'primevue/config';
//theme
import "primevue/resources/themes/lara-light-indigo/theme.css";     
//core
import "primevue/resources/primevue.min.css";
//icons
import "primeicons/primeicons.css";
import ConfirmationService from 'primevue/confirmationservice'; // notificacion de confirmacion
import ToastService from 'primevue/toastservice';

//apexCharts
import VueApexCharts from "vue3-apexcharts";

import LaravelPermissionToVueJS from 'laravel-permission-to-vuejs'


const appName = window.document.getElementsByTagName('title')[0]?.innerText || 'Laravel';     

createInertiaApp({
    title: (title) => `${title}`,
    resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue')),
    setup({ el, App, props, plugin }) {
        return createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(ZiggyVue, Ziggy)
            .use(PrimeVue)
            .use(ConfirmationService)
            .use(ToastService)
            .use(LaravelPermissionToVueJS)
            .use(VueApexCharts) //The .use(VueApexCharts) will make <apexchart> component available everywhere.
            .mount(el);
    },
    progress: {
        color: '#4B5563',
    },
});
