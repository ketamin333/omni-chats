<script setup>
    import {onMounted, ref} from "vue";
    import {getUsers} from "../api/users.js";
    import {DataTable, Column, Button, Dialog} from 'primevue';
    import UserRoleBadge from "../components/User/UserRoleBadge.vue";
    import {UserRoundPlus} from 'lucide-vue-next';
    import CreateUserForm from "../components/User/CreateUserForm.vue";

    const loading = ref(false);
    const users = ref([]);
    const total = ref(0);
    const page = ref(1);
    const perPage = 25;

    onMounted(() => loadUsers());

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

    const formRef = ref(null);

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
            rowHover
        >
            <template #header>
                <div class="shrink-0 flex justify-between items-center">
                    <div class="flex items-center font-semibold text-2xl gap-2">
                        <span class="text-color">Пользователи</span>
                        <span class="text-muted-color">{{ total }}</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <Button size="small" @click="visibleCreate = true">
                            <UserRoundPlus size="16" />
                            Создать
                        </Button>
                    </div>
                </div>
            </template>
            <Column header="Пользователь">
                <template #body="{data}">
                    <div class="flex gap-2 items-center">
                        <img :src="data.avatar" width="32" height="32" alt="" />
                        <span class="text-sm font-medium text-color">{{ data.username }}</span>
                    </div>
                </template>
            </Column>
            <Column header="Телефон">
                <template #body="{data}">
                    <span class="text-sm text-muted-color">{{ data.phone }}</span>
                </template>
            </Column>
            <Column header="Email">
                <template #body="{data}">
                    <span class="text-sm text-muted-color">{{ data.email }}</span>
                </template>
            </Column>
            <Column header="Роль">
                <template #body="{data}">
                    <UserRoleBadge :role="data.role" />
                </template>
            </Column>
        </DataTable>
    </div>

    <Dialog v-model:visible="visibleCreate"
            modal :closable="false" class="w-[38rem]" :show-header="false">
        <template #default>
            <div class="pt-6">
                <CreateUserForm ref="formRef" />
            </div>
        </template>

        <template #footer>
            <Button size="small" text @click="visibleCreate = false">Отмена</Button>
            <Button size="small">Создать</Button>
        </template>
    </Dialog>
</template>
