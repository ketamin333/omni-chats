import { createApp } from 'vue';
import { createPinia } from 'pinia';
import App from './App.vue';
import router from './router';
import PrimeVue from 'primevue/config';
import preset from "./theme.js";

const app = createApp(App);

app.use(createPinia());
app.use(router);

app.use(PrimeVue, {
    theme: {
        preset: preset,
        options: { darkModeSelector: '.dark', }
    }
});

app.mount('#app');
