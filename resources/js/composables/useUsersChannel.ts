import echo from '@/echo';
import { useAuthStore } from "@/stores/useAuthStore";
import { watch, Ref } from "vue";
import {User, UserList} from "@/types/user";

export function useUsersChannel(users: Ref<UserList[]>, total: Ref<number>) {
    const auth = useAuthStore();

    const subscribe = () => {
        watch(() => auth.user, user => {
            if (!user) return;

            echo.private(`users.${user.company_id}`)
                .listen('UserCreated', (user: User) => {
                    users.value.unshift(user);
                    total.value++;
                })
                .listen('UserUpdated', (user: User) => {
                    const index = users.value.findIndex(u => u.user_id === user.user_id);
                    if (index !== -1) users.value[index] = user;
                })
                .listen('UserDeleted', (user: User) => {
                    users.value = users.value.filter(u => u.user_id !== user.user_id);
                    total.value--;
                });
        }, { immediate: true });
    };

    const unsubscribe = () => {
        if (auth.user) echo.leave(`users.${auth.user.company_id}`);
    };

    return { subscribe, unsubscribe };
}
