<script setup>
    import {Avatar} from "primevue";
    import {Camera, Plus} from "lucide-vue-next";
    import {ref} from "vue";

    const props = defineProps({ avatar: String|null });
    const emit = defineEmits(['update:avatar']);

    const $input = ref(null);
    const preview = ref(null);

    const onAvatarUpload = e => {
        const file = e.target.files[0];

        if (file) {
            preview.value = URL.createObjectURL(file);
            emit('update:avatar', file);
        }
    };
</script>

<template>
    <div class="flex flex-col items-center gap-2">
        <div class="relative cursor-pointer" @click="$input.click()">
            <input ref="$input" type="file" accept="image/*" hidden @change="onAvatarUpload" />
            <Avatar shape="circle" class="!w-24 !h-24 shadow-sm" :image="preview || props.avatar">
                <template #icon v-if="!props.avatar && !preview"><Camera size="36" /></template>
            </Avatar>
            <div class="absolute bottom-0 right-0 rounded-full text-surface-0 bg-surface-950 p-1 flex items-center">
                <Plus size="14" />
            </div>
        </div>
        <div class="flex flex-col items-center">
            <span class="text-base font-medium text-color">Фото профиля</span>
            <span class="text-sm text-muted-color">JPG или PNG, не более 2 МБ</span>
        </div>
    </div>
</template>
