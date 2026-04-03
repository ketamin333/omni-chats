<script setup>
import {onMounted, onUnmounted, ref} from "vue";
    import {getUsers} from "../api/users.js";
    import {DataTable, Column, Button, Avatar} from 'primevue';
    import {UserRoundPlus} from 'lucide-vue-next';
    import CreateUserForm from "../components/User/CreateUserForm.vue";
    import echo from "../echo.js";

    const loading = ref(false);
    const users = ref([]);
    const total = ref(0);
    const page = ref(1);
    const perPage = 25;

    onMounted(() => {
        loadUsers();

        echo.private('users')
            .listen('UserCreated', e => {
                users.value.unshift(e);
                total.value++;
            });
    });

    onUnmounted(() => echo.leave('users'));

    const loadUsers = async () => {
        loading.value = true;

        const { data } = await getUsers(page.value);

        users.value = data.data.data;
        total.value = data.data.meta.total;
        loading.value = false;
    };

    const visibleCreate = ref(false);

    const onPage = async event => {
        page.value = event.page + 1;
        await loadUsers();
    };
</script>

<template>
    <div class="flex flex-col h-full overflow-hidden pt-1 pb-2 text-base">
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
            rowHover
        >
            <template #header>
                <div class="shrink-0 flex justify-between items-center">
                    <div class="flex items-center font-semibold text-2xl gap-2">
                        <span class="text-color">Пользователи</span>
                        <span class="text-muted-color">{{ total }}</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <Button @click="visibleCreate = true">
                            <UserRoundPlus size="14" />
                            Создать
                        </Button>
                    </div>
                </div>
            </template>
            <Column header="Пользователь">
                <template #body="{data}">
                    <div class="flex gap-2 items-center">
                        <Avatar shape="circle" size="normal" :image="data?.avatar_url || undefined"
                                :label="!data?.avatar_url ? data?.username?.charAt(0).toUpperCase() : undefined" />
                        <span class="font-medium text-color">{{ data?.username }}</span>
                    </div>
                </template>
            </Column>
            <Column header="Email">
                <template #body="{data}">
                    <span class="text-muted-color">{{ data?.email }}</span>
                </template>
            </Column>
            <Column header="Телефон">
                <template #body="{data}">
                    <span class="text-muted-color">{{ data?.phone }}</span>
                </template>
            </Column>
        </DataTable>
    </div>

    <CreateUserForm v-model:visible="visibleCreate" />
</template>
