import { defineStore } from 'pinia';
import { ref, watch } from 'vue';

// export const useThemeStore = defineStore('theme', {
//     state:() => ({
//         theme:
//     }),
//     getters: {
//         theme: state.theme,
//
//     },
//     actions: {
//         toggle() =>
//     }
// })

export const useThemeStore = defineStore('theme', () => {
    const stored = localStorage.getItem('theme');
    const isDark = ref(stored !== 'light');

    function toggle() {
        isDark.value = !isDark.value;
    }

    watch(isDark, val => {
        localStorage.setItem('theme', val ? 'dark' : 'light');
        document.documentElement.classList.toggle('dark', val);
    }, { immediate: true });

    return { isDark, toggle };
});
