import {createApp} from 'vue';
import {createPinia} from 'pinia';
import AppLayout from "@/layouts/AppLayout.vue";
import router from './router/index';
import PrimeVue from 'primevue/config';
import preset from "./theme";
import ToastService from 'primevue/toastservice';
import DialogService  from 'primevue/dialogservice';
import ConfirmationService from 'primevue/confirmationservice';
import Tooltip from 'primevue/tooltip';

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
    toast: { life: 5000 },
    dialog: { header: false, }
});

app.directive('tooltip', Tooltip);

app.mount('#app');
