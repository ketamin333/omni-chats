import echo from '@/echo';
import { ref, watch, Ref } from 'vue';
import { useAuthStore } from "@/stores/useAuthStore";

const onlineUsers: Ref<Set<number>> = ref(new Set());

export function useOnlineChannel() {
    const auth = useAuthStore();

    const subscribe = () => {
        watch(() => auth.user, user => {
            if (!user) return;

            echo.join(`online.${user.company_id}`)
                .here((users: { user_id: number }[]) => {
                    onlineUsers.value = new Set(users.map(u => u.user_id));
                })
                .joining((user: { user_id: number }) => {
                    onlineUsers.value.add(user.user_id);
                })
                .leaving((user: { user_id: number }) => {
                    onlineUsers.value.delete(user.user_id);
                });
        }, { immediate: true });
    };

    const unsubscribe = () => {
        if (auth.user) echo.leave(`online.${auth.user.company_id}`);
    };

    return { onlineUsers, subscribe, unsubscribe };
}
