<script setup>
    import {Check} from "lucide-vue-next";
    import {adapterTypesConfig, adapterNamesConfig} from "../../config/adapterConfig.js";
    import {Avatar} from "primevue";
    import {computed} from "vue";

    const props = defineProps({ adapter: Object, active: Number });
    const emit = defineEmits(['update:active']);

    const typesList = computed(
        () => (props.adapter.types || []).map(type => ({
            ...type,
            config: {
                ...adapterNamesConfig[props.adapter.adapter_name].slugs[type.adapter_type],
                ...adapterTypesConfig[type.adapter_type],
            }})
        )
    );

    const onAdapterTypeClick = adapterId => emit('update:active', adapterId);
    const isActive = adapterId => props.active === adapterId;
</script>

<template>
    <div
        v-for="{ adapter_type: type, adapter_id, config } in typesList"
        @click="onAdapterTypeClick(adapter_id)"
        :key="type"
        class="p-4 rounded-lg border-surface flex items-center cursor-pointer justify-between border"
        :class="{'!border-primary': isActive(adapter_id)}"
    >
        <div class="flex gap-2 items-center">
            <Avatar class="!w-[2.5rem] !h-[2.5rem]">
                <component :is="config.icon" size="14" />
            </Avatar>
            <div class="flex-col">
                <div class="flex items-center gap-2">
                    <span class="font-medium text-base">{{ config.label }}</span>
                </div>
                <div class="text-sm text-muted-color">{{ config.description }}</div>
            </div>
        </div>
        <Check v-show="isActive(adapter_id)" size="14" />
    </div>
</template>
