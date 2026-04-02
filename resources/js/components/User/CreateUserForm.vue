<script setup>
    import {Dialog, InputText, IconField, InputIcon, Password, InputMask,
        Button, Tabs, Tab, TabList, TabPanels, TabPanel, Avatar, ToggleSwitch} from "primevue";
    import {UserRoundCog, UserRoundKey, UserRound, Plus, Mail, Camera} from "lucide-vue-next";
    import {computed, onMounted, ref, watch} from "vue";
    import {getPermissions} from "../../api/permissions.js";
    import {createUser} from "../../api/users.js";

    const props = defineProps({ visible: Boolean });
    const emit = defineEmits(['update:visible']);

    const permissions = ref([]);
    const fileInput = ref(null);
    const avatarPreview = ref(null);

    const localVisible = computed({
        get: () => props.visible,
        set: (val) => emit('update:visible', val)
    });

    onMounted(() => loadPermissions());

    const user = ref({
        username: null,
        email: null,
        password: null,
        password_confirmation: null,
        avatar: null,
        phone: null,
        permissions: [],
    });

    const loadPermissions =  async () => {
        const { data } = await getPermissions();
        permissions.value = data.data;
    };

    const togglePermission = (slug, value) => value
        ? user.value.permissions.push(slug)
        : user.value.permissions = user.value.permissions.filter(p => p !== slug);

    const onAvatarUpload = e => {
        const file = e.target.files[0];

        if (!file) {
            return;
        }

        avatarPreview.value = URL.createObjectURL(file);
        user.value.avatar = file;
    }

    const handlerCreateUser = async () => {
        const response = await createUser(user.value);
        console.log(response);
    }
</script>

<template>
    <Dialog modal v-model:visible="localVisible" :show-header="false" class="w-[40rem]">
        <div class="flex flex-col gap-6 pt-6">
            <div class="flex justify-center items-center">
                <div class="flex relative cursor-pointer">
                    <input ref="fileInput" type="file" accept="image/*" hidden @change="onAvatarUpload" />
                    <Avatar shape="circle" class="!w-24 !h-24 cursor-pointer shadow-sm"
                            @click="fileInput.click()" :image="avatarPreview">
                        <template #icon v-if="!user.avatar"><Camera size="36"/></template>
                    </Avatar>
                    <div class="absolute bottom-0 right-0 rounded-full text-surface-0 bg-surface-950 p-1 flex items-center">
                        <Plus size="14" />
                    </div>
                </div>
            </div>
            <Tabs value="general">
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
                        <div class="flex flex-col gap-3">
                            <div v-for="permission in permissions" class="flex items-start gap-2">
                                <ToggleSwitch @update:model-value="val => togglePermission(permission.slug, val)" />
                                <label class="flex flex-col">
                                    <span class="font-semibold text-base">{{ permission.label }}</span>
                                    <span class="text-muted-color">{{ permission.description }}</span>
                                </label>
                            </div>
                        </div>
                    </TabPanel>
                </TabPanels>
            </Tabs>
        </div>
        <template #footer>
            <div class="flex gap-2 px-6 pb-6">
                <Button outlined @click="localVisible = false">
                    Закрыть
                </Button>
                <Button @click="handlerCreateUser">
                    Создать
                </Button>
            </div>
        </template>
    </Dialog>
</template>
