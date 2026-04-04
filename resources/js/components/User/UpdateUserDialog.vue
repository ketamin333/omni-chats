<script setup>
    import {ref, inject, onMounted} from "vue";
    import {deleteUser, getUser, updateUser, updateUserAvatar} from "../../api/users.js";
    import {
        IconField, InputIcon, InputMask, InputText, Password, Tab, TabList,
        TabPanel, TabPanels, Tabs, Button,
    } from "primevue";
    import AvatarUserUpload from "./AvatarUserUpload.vue";
    import {Mail, UserRoundCog, UserRoundKey, LockKeyhole, Trash2} from "lucide-vue-next";
    import UserPermissionToggle from "./UserPermissionToggle.vue";
    import {useConfirm} from "primevue/useconfirm";
    import {useToast} from "primevue/usetoast";

    onMounted(() => loadUser());

    const dialog = inject('dialogRef');
    const userId = dialog.value.data.userId;
    const confirm = useConfirm();
    const loading = ref(false);
    const toast = useToast();

    const user = ref({
        username: null,
        email: null,
        phone: null,
        avatar_url: null,
        permissions: [],
        avatar: File|null,
    });

    const loadUser = async () => user.value = (await getUser(userId)).data;
    const hide = () => dialog.value.close();

    const confirmDeleteUser = () => {
        confirm.require({
            modal: true,
            message: 'Пользователь будет помечен как удалённый и скрыт из активного списка',
            header: 'Вы действительно хотите удалить пользователя?',
            accept: async () => {
                await deleteUser(userId);
                hide();
            },
        });
    };

    const handleUpdateUser = async () => {
        loading.value = true;

        try {
            await updateUser(userId, {
                username: user.value.username,
                phone: user.value.phone,
                permissions: user.value.permissions,
            });

            if (user.value.avatar instanceof File) {
                await updateUserAvatar(userId, user.value.avatar);
            }

            hide();
        } catch (e) {
            toast.add({ severity: 'error', summary: 'Не удалось обновить пользователя', detail: e.response?.data?.message })
        } finally {
            loading.value = false;
        }
    }
</script>

<template>
    <div class="flex flex-col py-6">
        <div class="flex justify-center items-center">
            <AvatarUserUpload :avatar="user.avatar_url" v-model:avatar="user.avatar" />
        </div>
        <Tabs value="general" class="pt-6">
            <TabList>
                <Tab value="general" as="div" class="flex gap-2 items-center text-base">
                    <UserRoundCog size="14" />
                    <span>Настройки</span>
                </Tab>
                <Tab value="permissions" as="div" class="flex gap-2 items-center text-base">
                    <UserRoundKey size="14" />
                    <span>Доступы</span>
                </Tab>
                <Tab value="password" as="div" class="flex gap-2 items-center text-base">
                    <LockKeyhole size="14" />
                    <span>Сменить пароль</span>
                </Tab>
            </TabList>
            <TabPanels>
                <TabPanel value="general" as="div">
                    <div class="grid grid-cols-2 gap-3">
                        <div class="flex flex-col">
                            <label for="userUsername" class="form-label required">Имя пользователя</label>
                            <InputText id="userUsername" v-model="user.username" fluid placeholder="Имя пользователя" required maxlength="255" />
                        </div>
                        <div class="flex flex-col">
                            <label for="userEmail" class="form-label required">Email</label>
                            <IconField>
                                <InputIcon><Mail size="14" /></InputIcon>
                                <InputText id="userEmail" disabled v-model="user.email" fluid placeholder="Email" required maxlength="255" />
                            </IconField>
                        </div>
                        <div class="flex flex-col">
                            <label for="userPassword" class="form-label required">Пароль</label>
                            <Password input-id="userPassword" disabled fluid placeholder="Пароль" required maxlength="255" :feedback="false" />
                        </div>
                        <div class="flex flex-col">
                            <label for="userPhone" class="form-label">Телефон</label>
                            <InputMask id="userPhone" v-model="user.phone" fluid mask="(999) 999-99-99" placeholder="Телефон" />
                        </div>
                    </div>
                </TabPanel>
                <TabPanel value="permissions" as="div">
                    <UserPermissionToggle :active="user.permissions" v-model:active="user.permissions" />
                </TabPanel>
            </TabPanels>
        </Tabs>
        <div class="flex justify-between px-6">
            <Button severity="danger" variant="text" @click="confirmDeleteUser">
                <Trash2 size="14" /> Удалить
            </Button>
            <div class="flex gap-2">
                <Button outlined @click="hide" label="Закрыть" />
                <Button label="Сохранить" :loading="loading" @click="handleUpdateUser" />
            </div>
        </div>
    </div>
</template>
