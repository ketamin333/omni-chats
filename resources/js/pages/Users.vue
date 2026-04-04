<script setup>
    import {onMounted, onUnmounted, ref} from "vue";
    import {getUsers} from "../api/users.js";
    import {DataTable, Column, Button, Avatar} from 'primevue';
    import {UserRoundPlus} from 'lucide-vue-next';
    import CreateUserDialog from "../components/User/CreateUserDialog.vue";
    import UpdateUserDialog from "../components/User/UpdateUserDialog.vue";
    import {useDialog} from "primevue/usedialog";
    import {useUsersChannel} from '../composables/useUsersChannel.js';

    const loading = ref(false);
    const users = ref([]);
    const total = ref(0);
    const page = ref(1);
    const perPage = 25;
    const dialog = useDialog();
    const { subscribe, unsubscribe } = useUsersChannel(users, total);

    onMounted(() => {
        loadUsers();
        subscribe();
    });

    onUnmounted(() => unsubscribe());

    const loadUsers = async () => {
        loading.value = true;

        const { data } = await getUsers(page.value);

        users.value = data.data;
        total.value = data.meta.total;
        loading.value = false;
    };

    const showCreateDialog = ref(false);

    const onPage = async e => {
        page.value = e.page + 1;
        await loadUsers();
    };

    const onRowClick = e => {
        dialog.open(UpdateUserDialog, {
            props: {
                modal: true,
                showHeader: false,
                class: 'w-[44rem]',
            },
            data: {
                userId: e.data.user_id,
            }
        });
    };

    const onCreateClick = () => {
        dialog.open(CreateUserDialog, {
            props: {
                modal: true,
                showHeader: false,
                class: 'w-[44rem]',
            },
        });
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
            @row-click="onRowClick"
        >
            <template #header>
                <div class="shrink-0 flex justify-between items-center">
                    <div class="flex items-center font-semibold text-2xl gap-2">
                        <span class="text-color">Пользователи</span>
                        <span class="text-muted-color">{{ total }}</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <Button @click="onCreateClick">
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
</template>
