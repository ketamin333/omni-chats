import { watch } from 'vue';

export const useDebounce = (source, callback, delay = 400) => {
    let timer = null;

    watch(source, () => {
        clearTimeout(timer);
        timer = setTimeout(callback, delay);
    });
};
