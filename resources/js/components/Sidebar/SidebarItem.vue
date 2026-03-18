<script setup>
    import { Button } from "primevue";

    defineProps({item: Object});
</script>

<template>
    <Button as="RouterLink" :to="item.to" variant="text" fluid size="small"
            class="!justify-start !flex" active-class="!bg-surface-100">
        <component :is="item.icon" size="16" />
        {{ item.label }}
    </Button>
</template>
