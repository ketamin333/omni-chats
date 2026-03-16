<script setup>
    import {useAuthStore} from "../../stores/auth.js";
    import { Image, Button, Popover, InputText } from "primevue";
    import { EllipsisVertical, LogOut, Folders, ListChecks } from "lucide-vue-next";
    import { ref } from 'vue';
    import SidebarGroupItems from "./SidebarGroupItems.vue";
    import groups from "../../config/navigation.js";

    const auth = useAuthStore();

    const popover = ref();
    const toggle = (event) => popover.value.toggle(event);

    async function logout() {
        await auth.logout();
        window.location.href = '/login';
    }
</script>

<template>
    <div class="h-full flex flex-col justify-between shrink-0 grow bg-surface-0 rounded-xl shadow-sm">
        <div class="flex flex-col shrink-0 grow p-3 gap-4">
            <SidebarGroupItems v-for="group in groups" :group="group" :key="group.label" />
        </div>
        <div class="flex border-t p-3 justify-between gap-4 items-center border-surface-200">

        </div>
<!--        <div class="">-->
<!--            <div class="flex gap-3 items-center">-->
<!--                <Image :src="auth.user?.avatar" :pt="{ image: { class: 'w-9 h-9 rounded-full object-cover' } }" />-->
<!--                <div class="flex flex-col">-->
<!--                    <span class="text-sm font-medium">{{ auth.user?.username }}</span>-->
<!--                    <span class="text-xs text-surface-500">{{ auth.user?.email }}</span>-->
<!--                </div>-->
<!--            </div>-->
<!--            <Button size="small" variant="text" @click="toggle" severity="secondary">-->
<!--                <template #icon><EllipsisVertical size="16" /></template>-->
<!--            </Button>-->
<!--            <Popover ref="popover">-->
<!--                <div class="flex flex-col gap-1">-->
<!--                    <Button variant="text" fluid size="small" label="Выйти" @click="logout">-->
<!--                        <template #icon><LogOut size="16" /></template>-->
<!--                    </Button>-->
<!--                </div>-->
<!--            </Popover>-->
<!--        </div>-->
    </div>
</template>
