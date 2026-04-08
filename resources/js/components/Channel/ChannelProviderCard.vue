<script setup>
    import {providerConfig} from "../../config/channelConfig.js";
    import {Check} from "lucide-vue-next";
    import {Tag} from "primevue";

    const props = defineProps({ providers: Array, active: Object });
    const emit = defineEmits(['update:active']);

    const onProviderClick = slug => emit('update:active', getProvider(slug));

    const getProvider = slug => props.providers.find(p => p.slug === slug);
    const getConfig = slug => providerConfig[slug];
    const isActive = slug => props.active?.slug === slug;
</script>

<template>
    <div
        v-for="{slug, name, types = []} in providers"
        @click="onProviderClick(slug)"
        :key="slug"
        :class="[getConfig(slug).color, isActive(slug) ? getConfig(slug).borderColor : null]"
        class="p-4 rounded-lg border-surface flex items-center cursor-pointer justify-between border"
    >
        <div class="flex gap-2 items-center">
            <div class="w-[2rem] h-[2rem]"></div>
            <div class="flex-col">
                <div class="flex items-center gap-2">
                    <span class="font-medium text-base" :class="getConfig(slug).color">{{ name }}</span>
                    <Tag :value="types.length" :severity="getConfig(slug).tagSeverity" />
                </div>
                <div class="text-sm text-muted-color">{{ getConfig(slug).description }}</div>
            </div>
        </div>
        <Check v-show="isActive(slug)" size="14" />
    </div>
</template>
