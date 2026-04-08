<script setup>
    import {adapterNamesConfig} from "../../config/adapterConfig.js";
    import {Check} from "lucide-vue-next";
    import {Tag} from "primevue";
    import {computed} from "vue";

    const props = defineProps({ adapters: Array, active: String });
    const emit = defineEmits(['update:active']);

    const adaptersList = computed(
        () => props.adapters.map(adapter => ({...adapter, config: adapterNamesConfig[adapter.adapter_name]}))
    );

    const onAdapterNameClick = name => emit('update:active', name);
    const isActive = name => props.active === name;
</script>

<template>
    <div
        v-for="{ adapter_name: name, types, config } in adaptersList"
        :key="name"
        @click="onAdapterNameClick(name)"
        class="p-4 rounded-lg border-surface flex items-center cursor-pointer justify-between border"
        :class="[config.color, isActive(name) ? config.borderColor : null]"
    >
        <div class="flex gap-2 items-center">
            <div class="w-[2rem] h-[2rem]"></div>
            <div class="flex-col">
                <div class="flex items-center gap-2">
                    <span class="font-medium text-base">{{ config.label }}</span>
                    <Tag :value="types.length" :severity="config.tagSeverity || 'contrast'" />
                </div>
                <div class="text-sm text-muted-color">{{ config.description }}</div>
            </div>
        </div>
        <Check v-show="isActive(name)" size="14" />
    </div>
</template>
