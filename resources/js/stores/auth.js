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
        async fetchUser(force = false) {
            if (this.initialized && !force) {
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
                await login(data);
                await this.fetchUser(true);
            } catch (e) {
                this.user = null;
                throw e;
            }
        }
    },
});
