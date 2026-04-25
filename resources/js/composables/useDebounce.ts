import { watch, Ref } from 'vue';

export const useDebounce = (source: Ref, callback: () => void, delay: number = 400) => {
    let timer: ReturnType<typeof setTimeout> | null = null;

    watch(source, () => {
        if (timer) clearTimeout(timer);
        timer = setTimeout(callback, delay);
    });
};
