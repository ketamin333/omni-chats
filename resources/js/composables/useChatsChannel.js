import echo from '../echo.js';
import {useAuthStore} from "../stores/useAuthStore.js";
import {watch} from "vue";

export function useChatsChannel(onMessage) {
    const auth = useAuthStore();

    const subscribe = () => {
        watch(() => auth.user, user => {
            if (!user) {
                return;
            }

            echo.private(`chats.${user.company_id}`)
                .listen('MessageCreated', onMessage);


        }, { immediate: true });
    };

    const unsubscribe = () => {
        if (auth.user) {
            echo.leave(`chats.${auth.user.company_id}`);
        }
    };

    return { subscribe, unsubscribe };
}
