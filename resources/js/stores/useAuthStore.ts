import {defineStore} from 'pinia';
import {csrf, login, logout, me} from "@/api/auth";
import {ref, computed} from 'vue';
import {User, LoginUserData} from "@/types/user";

export const useAuthStore = defineStore('auth', () => {
    const user = ref<User|null>(null);
    const initialized = ref(false);

    const isAuthenticated = computed(() => !!user.value);

    const fetchUser = async (force = false) => {
        if (initialized.value && !force) {
            return;
        }

        try {
            user.value = (await me()).data;
        } catch {
            user.value = null;
        } finally {
            initialized.value = true;
        }
    };

    const loginUser = async (data: LoginUserData) => {
        if (isAuthenticated.value) {
            return;
        }

        try {
            await csrf();
            await login(data);
            await fetchUser(true);
        } catch (e) {
            user.value = null;
            throw e;
        }
    };

    const logoutUser = async () => {
        if (!isAuthenticated.value) {
            return;
        }

        await logout();
    };

    return { user, initialized, isAuthenticated, fetchUser, loginUser, logoutUser };
});
