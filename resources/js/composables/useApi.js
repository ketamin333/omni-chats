import {ref} from 'vue';
import {useToast} from 'primevue/usetoast';

export const useApi = () => {
    const loading = ref(false);
    const toast = useToast();

    const execute = async (action, { onSuccess, successMessage } = {}) => {
        loading.value = true;
        try {
            await action();

            if (successMessage) {
                toast.add({ severity: 'success', summary: successMessage });
            }

            onSuccess?.();
        } catch (e) {
            toast.add({ severity: 'error', summary: e.message, detail: e.errors });
        } finally {
            loading.value = false;
        }
    };

    return { loading, execute };
};
