<script setup>
    import {useAuthStore} from "@/stores/useAuthStore.ts";
    import {Image, Button, InputText, Menu, IconField, InputIcon, Avatar} from "primevue";
    import { ChevronRight, LogOut, Layers, Search } from "lucide-vue-next";
    import {ref} from 'vue';
    import SidebarGroupItems from "./SidebarGroupItems.vue";
    import groups from "../../config/navigation.js";

    const auth = useAuthStore();

    const userMenu = ref();

    const logout = async () => {
        await auth.logout();
        window.location.href = '/login';
    };

    const menuItems = [
        {
            label: 'Основное',
            items: [
                { label: 'Выйти', icon: LogOut, command: () => logout() }
            ]
        }
    ];

    const toggleMenu = e => userMenu.value.toggle(e);
</script>

<template>
    <div class="h-full flex flex-col justify-between">
        <div class="flex flex-col grow gap-4 p-4">
            <RouterLink :to="{ name: 'dashboard' }" class="flex items-center gap-1 justify-center mb-4">
                <Layers size="24" stroke-width="2.25" />
                <Image src="/storage/logo_name.svg" :pt="{ image: { class: 'h-[1.5rem]' } }" />
            </RouterLink>
            <IconField>
                <InputIcon><Search size="14" /></InputIcon>
                <InputText placeholder="Поиск..." fluid type="text" as="button" />
            </IconField>
            <SidebarGroupItems v-for="group in groups" :group="group" :key="group.label" />
        </div>
        <div class="flex justify-between gap-2 items-center px-4 py-3 bg-surface-0 shadow-sm rounded-lg">
            <div class="flex gap-2 items-center flex-1 min-w-0">
                <Avatar :image="auth.user?.avatar_url"
                        :label="!auth.user?.avatar_url ? auth.user?.username?.charAt(0).toUpperCase() : undefined"
                        shape="circle" class="shrink-0" />
                <div class="flex flex-col min-w-20 overflow-hidden flex-1">
                    <span class="font-semibold truncate text-color text-base">{{ auth.user?.username }}</span>
                    <span class="truncate text-sm text-muted-color">{{ auth.user?.email }}</span>
                </div>
            </div>
            <Button variant="outlined" size="small" rounded class="shrink-0" @click="toggleMenu">
                <template #icon><ChevronRight size="14" /></template>
            </Button>
            <Menu ref="userMenu" :popup="true" :model="menuItems">
                <template #item="{ item }">
                    <div class="p-menu-item-link" @click="item.command">
                        <component :is="item.icon" size="14"></component>
                        <span>{{ item.label }}</span>
                    </div>
                </template>
            </Menu>
        </div>
    </div>
</template>
