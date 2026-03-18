<script setup>
    defineProps({
        avatar: String,
        username: String,
        email: String,
    });
</script>

<template>
    <div class="flex gap-2 items-center min-w-0 flex-1">
        <img :src="avatar" class="shrink-0 w-9 h-9 rounded-full object-cover" alt="">
        <div class="flex flex-col min-w-0">
            <span class="text-sm font-medium truncate">{{ username }}</span>
            <span class="text-xs text-surface-500">{{ email }}</span>
        </div>
    </div>
</template>
