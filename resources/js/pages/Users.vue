<script setup>
import {onMounted, onUnmounted, ref} from "vue";
import {deleteUser, getUsers} from "../api/users.js";
    import {DataTable, Column, Button, Avatar, IconField, InputText, InputIcon, Tag} from 'primevue';
    import {Search, UserRoundPlus, X, MousePointerClick, SquarePen, Trash2, Mail,
        Phone, CalendarDays, CircleUserRound, CalendarPlus, CircleFadingPlus
    } from 'lucide-vue-next';
    import CreateUserDialog from "../components/User/CreateUserDialog.vue";
    import UpdateUserDialog from "../components/User/UpdateUserDialog.vue";
    import {useDialog} from "primevue/usedialog";
    import {useUsersChannel} from '../composables/useUsersChannel.js';
    import {useDebounce} from "../composables/useDebounce.js";
    import dayjs from "../config/dayjs.js";
    import {useOnlineChannel} from "../composables/useOnlineChannel.js";
    import {useConfirm} from "primevue/useconfirm";
    import {useToast} from "primevue/usetoast";

    const loading = ref(false);
    const sortField = ref(null);
    const sortOrder = ref(null);
    const search = ref('');
    const users = ref([]);
    const total = ref(0);
    const perPage = 25;
    const page = ref(1);

    const dialog = useDialog();
    const confirm = useConfirm();
    const toast = useToast();

    const { subscribe: subscribeUsers, unsubscribe: unsubscribeUsers } = useUsersChannel(users, total);
    const { onlineUsers } = useOnlineChannel();

    onMounted(() => {
        loadUsers();
        subscribeUsers();
    });

    onUnmounted(() => unsubscribeUsers());

    const isOnline = userId => onlineUsers.value.has(userId);

    const loadUsers = async () => {
        loading.value = true;
        const response = (await getUsers(page.value, sortField.value, sortOrder.value, search.value || null)).data;

        total.value = response.meta.total;
        users.value = response.data;
        loading.value = false;
    };

    const onPage = e => {
        page.value = e.page + 1;
        loadUsers();
    };

    const resetUsers = () => {
        page.value = 1;
        loadUsers();
    };

    useDebounce(search, resetUsers);

    const onSort = e => {
        sortField.value = e.sortField;
        sortOrder.value = e.sortOrder === 1
            ? 'asc' : 'desc';

        resetUsers();
    };

    const onUpdateUserClick = userId => dialog.open(UpdateUserDialog, {
        props: {
            modal: true,
            showHeader: false,
            class: 'w-[44rem]',
        },
        data: {userId}
    });

    const onDeleteUserClick = userId => confirm.require({
        modal: true,
        message: 'Пользователь будет помечен как удалённый и скрыт из активного списка',
        header: 'Вы действительно хотите удалить пользователя?',
        accept: async () => {
            try {
                await deleteUser(userId);
                toast.add({ severity: 'success', summary: 'Пользователь успешно удален' });
            } catch (e) {
                toast.add({ severity: 'error', summary: e.message, detail: e.errors });
            }
        },
    });

    const onCreateUserClick = () => dialog.open(CreateUserDialog, {
        props: {
            modal: true,
            showHeader: false,
            class: 'w-[44rem]',
        },
    });
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
            @page="onPage"
            :rows="perPage"
            :total-records="total"
            @sort="onSort"
            removable-sort
        >
            <template #header>
                <div class="shrink-0 flex justify-between items-start">
                    <div class="flex flex-col">
                        <div class="flex gap-2 items-center">
                            <span class="text-color font-bold text-2xl">Пользователи</span>
                            <Tag :value="total"></Tag>
                        </div>
                        <span class="text-muted-color text-base">Добавляйте сотрудников и настраивайте их права доступа</span>
                    </div>
                    <div class="flex gap-2">
                        <IconField>
                            <InputIcon><Search size="14" /></InputIcon>
                            <InputText v-model="search" fluid placeholder="Поиск..." maxlength="255" />
                            <InputIcon v-show="search" @click="search = null"><X size="14"/></InputIcon>
                        </IconField>
                        <Button @click="onCreateUserClick" label="Добавить">
                            <template #icon><UserRoundPlus size="14" /></template>
                        </Button>
                    </div>
                </div>
            </template>
            <Column header="Пользователь" field="username" :sortable="true">
                <template #header>
                    <CircleUserRound size="14" />
                </template>
                <template #body="{data: { username, avatar_url }}">
                    <div class="flex gap-2 items-center">
                        <Avatar shape="circle" size="normal" :image="avatar_url|| undefined"
                                :label="!avatar_url ? username?.charAt(0).toUpperCase() : undefined" />
                        <span class="font-medium text-color">{{ username }}</span>
                    </div>
                </template>
            </Column>
            <Column header="Email" :sortable="true" field="email">
                <template #header>
                    <Mail size="14" />
                </template>
                <template #body="{data: { email }}">
                    <span class="text-muted-color">{{ email }}</span>
                </template>
            </Column>
            <Column header="Создан" :sortable="true" field="created_at">
                <template #header>
                    <CalendarPlus size="14" />
                </template>
                <template #body="{data: { timestamps: { created_at } }}">
                    <span class="text-muted-color">
                        {{ dayjs.unix(created_at).format('DD/MM/YYYY') }}
                    </span>
                </template>
            </Column>
            <Column header="Активность">
                <template #header>
                    <CircleFadingPlus size="14" />
                </template>
                <template #body="{data: { user_id }}" >
                    <Tag v-bind="isOnline(user_id)
                        ? { value: 'В сети', severity: 'success' }
                        : { value: 'Не в сети', severity: 'primary' }"
                    />
                </template>
            </Column>
            <Column header="Телефон">
                <template #header>
                    <Phone size="14" />
                </template>
                <template #body="{data: { phone = null }}">
                    <span class="text-muted-color">{{ phone }}</span>
                </template>
            </Column>
            <Column header="Последний вход">
                <template #header>
                    <CalendarDays size="14" />
                </template>
                <template #body="{data: { timestamps: { last_login_at = null } }}">
                    <span class="text-muted-color">
                        {{ last_login_at ? dayjs.unix(last_login_at).fromNow() : 'Никогда' }}
                    </span>
                </template>
            </Column>
            <Column header="Действия">
                <template #header>
                    <MousePointerClick size="14" />
                </template>
                <template #body="{data: { user_id }}">
                    <div class="flex gap-2">
                        <Button outlined rounded severity="danger"
                                @click="onDeleteUserClick(user_id)"
                                v-tooltip.bottom="'Удалить'">
                            <template #icon>
                                <Trash2 size="14" />
                            </template>
                        </Button>
                        <Button outlined rounded
                                @click="onUpdateUserClick(user_id)"
                                v-tooltip.bottom="'Изменить'">
                            <template #icon>
                                <SquarePen size="14" />
                            </template>
                        </Button>
                    </div>
                </template>
            </Column>
        </DataTable>
    </div>
</template>
