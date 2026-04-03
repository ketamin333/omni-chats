import { createApp } from 'vue';
import { createPinia } from 'pinia';
import AppLayout from "./layouts/AppLayout.vue";
import router from './router';
import PrimeVue from 'primevue/config';
import preset from "./theme.js";
import ToastService from 'primevue/toastservice';

const app = createApp(AppLayout);

app.use(createPinia());
app.use(router);
app.use(ToastService);

app.use(PrimeVue, {
    theme: {
        preset: preset,
        options: { darkModeSelector: '.dark', }
    },
    toast: { life: 600000 }
});

app.mount('#app');
