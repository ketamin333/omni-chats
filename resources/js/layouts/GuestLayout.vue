<script setup>
import { useThemeStore } from '../stores/theme';

const theme = useThemeStore();
</script>

<template>
    <div class="">
        <RouterView />
    </div>
</template>
