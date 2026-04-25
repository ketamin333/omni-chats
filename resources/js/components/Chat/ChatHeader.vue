<script setup>
    import {computed} from "vue";
    import {Avatar, Button, Image} from "primevue";
    import {Search} from "lucide-vue-next";

    const props = defineProps({ conversation: Object });

    const username = computed(() => props.conversation?.contact?.username);
</script>

<template>
    <div class="p-4 flex justify-between items-center">
        <div class="flex items-center gap-2">
            <Avatar shape="circle" />
<!--            <Image shape="circle" />-->
            <div class="flex flex-col">
                <span class="text-color font-semibold text-base">{{ username }}</span>
            </div>
        </div>
        <div class="flex items-center gap-2"></div>
    </div>
</template>
