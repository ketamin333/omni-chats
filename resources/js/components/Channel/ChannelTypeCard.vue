<script setup>
    import {Check} from "lucide-vue-next";
    import {typeConfig} from "../../config/channelConfig.js";
    import {Avatar} from "primevue";

    const props = defineProps({ types: Array, active: Object });
    const emit = defineEmits(['update:active']);

    const onTypeClick = providerTypeId => emit('update:active', getType(providerTypeId));

    const getType = providerTypeId => props.types.find(t => t.provider_type_id === providerTypeId);
    const getConfig = slug => typeConfig[slug];
    const isActive = providerTypeId => props.active?.provider_type_id === providerTypeId;
</script>

<template>
    <div
        v-for="{type: {name, slug}, provider_type_id} in types"
        @click="onTypeClick(provider_type_id)"
        :key="slug"
        class="p-4 rounded-lg border-surface flex items-center cursor-pointer justify-between border"
        :class="{'!border-primary': isActive(provider_type_id)}"
    >
        <div class="flex gap-2 items-center">
            <Avatar class="!w-[2.5rem] !h-[2.5rem]">
                <component :is="getConfig(slug).icon" size="14" />
            </Avatar>
            <div class="flex-col">
                <div class="flex items-center gap-2">
                    <span class="font-medium text-base">{{ name }}</span>
                </div>
                <div class="text-sm text-muted-color">{{ getConfig(slug)?.description }}</div>
            </div>
        </div>
        <Check v-show="isActive(provider_type_id)" size="14" />
    </div>
</template>
