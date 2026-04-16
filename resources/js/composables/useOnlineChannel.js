import echo from '../echo.js';
import {ref, watch} from 'vue';
import {useAuthStore} from "../stores/useAuthStore.js";

const onlineUsers = ref(new Set());

export function useOnlineChannel() {

    const auth = useAuthStore();

    const subscribe = () => {
        watch(() => auth.user, (user) => {
            if (!user) return;

            echo.join(`online.${user.company_id}`)
                .here(users => {
                    onlineUsers.value = new Set(users.map(u => u.user_id));
                })
                .joining(user => {
                    onlineUsers.value.add(user.user_id);
                })
                .leaving(user => {
                    onlineUsers.value.delete(user.user_id);
                });
        }, { immediate: true });
    };


    const unsubscribe = () => {
        if (auth.user) {
            echo.leave(`online.${auth.user.company_id}`);
        }
    };

    return { onlineUsers, subscribe, unsubscribe };
}
