<script setup>
    import {
        InputText, IconField, InputIcon, Password, InputMask,
        Button, Tabs, Tab, TabList, TabPanels, TabPanel
    } from "primevue";
    import {useToast} from 'primevue/usetoast';
    import {UserRoundCog, UserRoundKey, Mail} from "lucide-vue-next";
    import {inject, ref} from "vue";
    import {createUser} from "../../api/users.js";
    import AvatarUserUpload from "./AvatarUserUpload.vue";
    import UserPermissionToggle from "./UserPermissionToggle.vue";

    const dialog = inject('dialogRef');
    const loading = ref(false);
    const toast = useToast();

    const user = ref({
        username: null,
        email: null,
        password: null,
        password_confirmation: null,
        avatar: null,
        phone: null,
        permissions: [],
    });

    const hide = () => dialog.value.close();

    const handlerCreateUser = async () => {
        loading.value = true;

        try {
            await createUser(user.value);

            toast.add({ severity: 'success', summary: 'Пользователь создан' });
            hide();
        } catch (e) {
            toast.add({ severity: 'error', summary: 'Ошибка создания', detail: e.response?.data?.message });
        } finally {
            loading.value = false;
        }
    };
</script>

<template>
    <div class="flex flex-col py-6">
        <div class="flex justify-center items-center">
            <AvatarUserUpload v-model:avatar="user.avatar" />
        </div>
        <Tabs class="pt-6" value="general">
            <TabList>
                <Tab value="general" as="div" class="flex gap-2 items-center text-base">
                    <UserRoundCog size="14" />
                    <span>Настройки</span>
                </Tab>
                <Tab value="permissions" as="div" class="flex gap-2 items-center text-base">
                    <UserRoundKey size="14" />
                    <span>Доступы</span>
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
                                <InputText id="userEmail" v-model="user.email" fluid placeholder="Email" required maxlength="255" />
                            </IconField>
                        </div>
                        <div class="flex flex-col">
                            <label for="userPassword" class="form-label required">Пароль</label>
                            <Password input-id="userPassword" v-model="user.password" fluid placeholder="Пароль" required maxlength="255" :feedback="false" toggleMask />
                        </div>
                        <div class="flex flex-col">
                            <label for="userPasswordConfirmed" class="form-label required">Подтвердите пароль</label>
                            <Password input-id="userPasswordConfirmed" v-model="user.password_confirmation" fluid placeholder="Пароль" required maxlength="255" :feedback="false" />
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
        <div class="flex gap-2 px-6 justify-end">
            <Button label="Закрыть" outlined @click="hide" />
            <Button @click="handlerCreateUser" :loading="loading" label="Создать" />
        </div>
    </div>
</template>
