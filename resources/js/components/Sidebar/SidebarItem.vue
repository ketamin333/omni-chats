<script setup>
    import {Button} from "primevue";

    defineProps({ item: Object });
</script>

<template>
    <Button as="RouterLink" :to="item?.to" variant="text" fluid
            class="!justify-start !flex !font-normal" active-class="!bg-surface-100">
        <component :is="item?.icon" size="14" />
        {{ item?.label }}
    </Button>
</template>
