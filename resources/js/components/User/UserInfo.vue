<script setup>
    import {Avatar} from 'primevue';

    defineProps({
        username: String,
        email: String,
        avatar: String,
    });
</script>

<template>
    <div class="flex gap-2 items-center min-w-0 flex-1">
        <Avatar :image="avatar || undefined"
                :label="!avatar ? username?.charAt(0).toUpperCase() : undefined"
                shape="circle" class="shrink-0" />
        <div class="flex flex-col min-w-0">
            <span class="font-semibold truncate text-color text-base">{{ username }}</span>
            <span class="text-muted-color">{{ email }}</span>
        </div>
    </div>
</template>
