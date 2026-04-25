import echo from '@/echo';
import { useAuthStore } from "@/stores/useAuthStore";
import { watch } from "vue";
import { Message } from "@/types/message";

export function useChatsChannel(onMessage: (message: Message) => void) {
    const auth = useAuthStore();

    const subscribe = () => {
        watch(() => auth.user, user => {
            if (!user) return;

            echo.private(`chats.${user.company_id}`)
                .listen('MessageCreated', onMessage);
        }, { immediate: true });
    };

    const unsubscribe = () => {
        if (auth.user) echo.leave(`chats.${auth.user.company_id}`);
    };

    return { subscribe, unsubscribe };
}
