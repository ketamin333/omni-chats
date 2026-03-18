<script setup>
    import {onMounted, ref} from "vue";
    import {getUsers} from "../api/users.js";
    import {DataTable, Column, Button, IconField, InputIcon, InputText} from 'primevue';
    import UserInfo from "../components/User/UserInfo.vue";
    import {UserRoundPlus} from 'lucide-vue-next';

    const loading = ref(false);
    const users = ref([]);
    const total = ref(0);
    const page = ref(1);
    const perPage = ref(25);

    onMounted(() => loadUsers());

    const loadUsers = async () => {
        loading.value = true;

        const { data } = await getUsers(page.value);

        users.value = data.data.data;
        total.value = data.data.meta.total;
        loading.value = false;
    };

    const onPage = async (event) => {
        page.value = event.page + 1;
        await loadUsers();
    };
</script>

<template>
    <div class="flex flex-col h-full overflow-hidden pt-1 pb-2">
        <DataTable
            scrollable
            scrollHeight="flex"
            :value="users"
            :loading="loading"
            lazy
            paginator
            :rows="perPage"
            :total-records="total"
            @page="onPage"
        >
            <template #header>
                <div class="shrink-0 flex justify-between items-center">
                    <div class="flex items-center font-semibold text-2xl gap-2">
                        <span class="text-surface-900">Пользователи</span>
                        <span class="text-surface-500">{{ total }}</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <Button size="small">
                            <UserRoundPlus size="16" />
                            Создать
                        </Button>
                    </div>
                </div>
            </template>
            <Column header="Пользователь">
                <template #body="{data}">
                    <UserInfo
                        :avatar="data.avatar"
                        :username="data.username"
                        :email="data.email"
                    />
                </template>
            </Column>
            <Column field="phone" header="Телефон">
                <template #body="{data}">
                    <span class="text-sm">{{ data.phone }}</span>
                </template>
            </Column>
        </DataTable>
    </div>
</template>
