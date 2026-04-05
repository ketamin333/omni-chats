<script setup>
    import {Toast} from "primevue";
    import {CircleX, X, CircleAlert, CircleCheck, Info} from "lucide-vue-next";
    import {computed} from "vue";

    const icon = computed(() => ({
        error: CircleX,
        warn: CircleAlert,
        success: CircleCheck,
    }));
</script>

<template>
    <Toast #container="{message, closeCallback}">
        <div class="grid grid-cols-[auto_1fr_auto] p-4 gap-3 items-start">
            <div class="mt-0.5 flex items-start">
                <component :is="icon[message?.severity] || Info" size="18"></component>
            </div>
            <div class="flex flex-col gap-2">
                <div class="font-medium text-base">{{ message?.summary }}</div>
                <ul v-if="Array.isArray(message.detail)" class="list-disc ps-4">
                    <li v-for="list in message.detail">{{ list }}</li>
                </ul>
                <ul v-else-if="message.detail && typeof message.detail === 'object'" class="list-disc ps-4">
                    <li v-for="item in Object.values(message.detail).flat()">{{ item }}</li>
                </ul>
                <span v-else-if="message.detail">{{ message.detail }}</span>
            </div>
            <X size="18" class="opacity-70 hover:opacity-100 cursor-pointer mt-0.5" @click="closeCallback" />
        </div>
    </Toast>
</template>
