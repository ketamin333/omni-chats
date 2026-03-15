import { defineStore } from 'pinia';
import {csrf, login, me} from "../api/auth.js";

export const useAuthStore = defineStore('auth', {
    state:() => ({
        user: null,
        initialized: false,
    }),

    getters: {
        isAuthenticated: (state) => !!state.user,
    },

    actions: {
        async fetchUser() {
            if (this.initialized) {
                return;
            }

            try {
                const { data } = await me();
                this.user = data;
            } catch {
                this.user = null;
            } finally {
                this.initialized = true;
            }
        },

        async login(data) {
            if (this.isAuthenticated) {
                return;
            }

            try {
                await csrf();
                const user = await login(data);

                console.log(user);

                this.user = user.data;
            } catch (e) {
                this.user = null;
                throw e;
            }
        }
    },
});
