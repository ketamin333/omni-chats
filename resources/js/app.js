import { createApp } from 'vue';
import { createPinia } from 'pinia';
import AppLayout from "./layouts/AppLayout.vue";
import router from './router';
import PrimeVue from 'primevue/config';
import preset from "./theme.js";
import ToastService from 'primevue/toastservice';
import DialogService  from 'primevue/dialogservice';
import ConfirmationService from 'primevue/confirmationservice';

const app = createApp(AppLayout);

app
    .use(createPinia())
    .use(router)
    .use(ToastService)
    .use(DialogService)
    .use(ConfirmationService);

app.use(PrimeVue, {
    theme: {
        preset: preset,
        options: { darkModeSelector: '.dark', }
    },
    toast: { life: 5000 }
});

app.mount('#app');
