<script setup>
    import SidebarItem from './SidebarItem.vue';

    defineProps({group: Object});
</script>

<template>
    <div class="flex flex-col gap-2">
        <span class="text-xs text-surface-500 px-2 font-semibold">{{ group.label }}</span>
        <div class="flex flex-col gap-1">
            <SidebarItem v-for="item in group.items" :key="item.to.name" :item="item" />
        </div>
    </div>
</template>
