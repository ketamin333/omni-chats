<script setup>
    import Sidebar from "../components/sidebar/Sidebar.vue";
    import { useThemeStore } from '../stores/theme';

    const theme = useThemeStore();
</script>

<template>
    <div class="flex gap-4 m-4 min-h-full min-w-full">
        <Sidebar />
        <div class="shrink"></div>
    </div>

    <RouterView />
</template>

<style scoped>

</style>
