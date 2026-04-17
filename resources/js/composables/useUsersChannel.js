import echo from '../echo.js';
import {useAuthStore} from "../stores/useAuthStore.js";
import {watch} from "vue";

export function useUsersChannel(users, total) {
    const auth = useAuthStore();

    const subscribe = () => {
        watch(() => auth.user, user => {
            if (!user) {
                return;
            }

            echo.private(`users.${auth.user.company_id}`)
                .listen('UserCreated', user => {
                    users.value.unshift(user);
                    total.value++;
                })
                .listen('UserUpdated', user => {
                    const userIndex = users.value.findIndex(u => u.user_id === user.user_id);
                    if (userIndex !== -1) {
                        users.value[userIndex] = user;
                    }
                })
                .listen('UserDeleted', user => {
                    users.value = users.value.filter(u => u.user_id !== user.user_id);
                    total.value--;
                });
        }, { immediate: true });
    };

    const unsubscribe = () => {
        if (auth.user) {
            echo.leave(`users.${auth.user.company_id}`);
        }
    };

    return { subscribe, unsubscribe };
}
