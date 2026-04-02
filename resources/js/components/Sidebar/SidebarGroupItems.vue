<script setup>
    import SidebarItem from './SidebarItem.vue';

    defineProps({group: Object});
</script>

<template>
    <div class="flex flex-col gap-2">
        <span class="text-sm text-muted-color px-2 font-semibold">{{ group.label }}</span>
        <div class="flex flex-col gap-1">
            <SidebarItem v-for="item in group.items" :key="item.to.name" :item="item" />
        </div>
    </div>
</template>
