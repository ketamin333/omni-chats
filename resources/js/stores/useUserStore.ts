import {ref} from "vue";
import {defineStore} from "pinia";
import {getUsers} from "@/api/users";
import {UserList} from "@/types/user";

export const useUserStore = defineStore('users', () => {
    const users = ref<UserList[]>([]);
    const loading = ref(false);
    const total = ref(0);
    const page = ref(1);
    const sortField = ref<string | null>(null);
    const sortOrder = ref<'asc' | 'desc' | null>(null);
    const search = ref<string | null>(null);

    const load = async () => {
        loading.value = true;
        const response = (await getUsers(page.value, sortField.value, sortOrder.value, search.value)).data;

        users.value = response.data;
        total.value = response.meta.total;

        loading.value = false;
    };

    return { users, loading, total, page, sortField, sortOrder, search, load };
});
