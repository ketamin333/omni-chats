<script setup>
    import {useAuthStore} from "../../stores/auth.js";
    import { Image, Button, InputText, Popover } from "primevue";
    import { ChevronRight, LogOut, Layers } from "lucide-vue-next";
    import { ref } from 'vue';
    import SidebarGroupItems from "./SidebarGroupItems.vue";
    import groups from "../../config/navigation.js";

    const auth = useAuthStore();

    const userPopover = ref();
    const toggle = event => userPopover.value.toggle(event);

    async function logout() {
        await auth.logout();
        window.location.href = '/login';
    }
</script>

<template>
    <div class="h-full flex flex-col justify-between bg-surface-0 rounded-xl shadow-sm">
        <div class="flex flex-col grow p-4 gap-4">
            <RouterLink :to="{ name: 'dashboard' }" class="flex items-center gap-1 justify-center mb-4">
                <Layers size="24" stroke-width="2.25" />
                <Image src="/storage/logo_name.svg" :pt="{ image: { class: 'h-[1.5rem]' } }" />
            </RouterLink>
            <InputText placeholder="Поиск..." size="small" type="text" />
            <SidebarGroupItems v-for="group in groups" :group="group" :key="group.label" />
        </div>
        <div class="flex p-3 justify-between gap-2 items-center">
            <div class="flex gap-2 items-center min-w-0 flex-1">
                <Image :src="auth.user?.avatar" class="shrink-0" :pt="{ image: { class: 'w-[2.25rem] h-[2.25rem] rounded-full object-cover' } }" />
                <div class="flex flex-col min-w-0">
                    <span class="text-sm font-medium truncate">{{ auth.user?.username }}</span>
                    <span class="text-xs text-surface-500">{{ auth.user?.email }}</span>
                </div>
            </div>
            <Button size="small" variant="text" severity="secondary" @click="toggle">
                <template #icon><ChevronRight size="16" /></template>
            </Button>
            <Popover ref="userPopover">
                <div class="flex flex-col gap-1">
                    <Button variant="text" fluid size="small" label="Выйти" @click="logout">
                        <template #icon><LogOut size="16" /></template>
                    </Button>
                </div>
            </Popover>
        </div>
    </div>
</template>
