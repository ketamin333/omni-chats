import { ref } from 'vue';
import { useToast } from 'primevue/usetoast';

interface ExecuteOptions {
    onSuccess?: () => void;
    successMessage?: string;
}

interface ApiError {
    message: string;
    errors?: Record<string, string[]>;
}

export const useApi = () => {
    const loading = ref(false);
    const toast = useToast();

    const execute = async (action: () => Promise<unknown>, options: ExecuteOptions = {}) => {
        loading.value = true;
        try {
            await action();

            if (options.successMessage) {
                toast.add({ severity: 'success', summary: options.successMessage });
            }

            options.onSuccess?.();
        } catch (e: unknown) {
            const error = e as ApiError;
            toast.add({ severity: 'error', summary: error.message, detail: error.errors });
        } finally {
            loading.value = false;
        }
    };

    return { loading, execute };
};
