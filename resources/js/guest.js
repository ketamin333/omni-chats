import { createApp } from 'vue';
import PrimeVue from 'primevue/config';
import preset from "./theme.js";
import Login from "./pages/Login.vue";
import {createPinia} from "pinia";

const app = createApp(Login);
app.use(createPinia());
app.use(PrimeVue, {
    theme: {
        preset: preset,
        options: { darkModeSelector: '.dark', }
    }
});

app.mount('#guest');
