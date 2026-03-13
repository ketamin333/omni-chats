<script setup>
import { useThemeStore } from '../stores/theme';

const theme = useThemeStore();
</script>

<template>
    <div class="min-h-screen bg-gray-200 dark:bg-gray-950 flex items-center justify-center transition-colors">
        <RouterView />
    </div>
</template>
