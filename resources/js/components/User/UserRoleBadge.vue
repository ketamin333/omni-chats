<script setup>
    import {computed} from "vue";
    import {Badge} from "primevue";

    const props = defineProps({
        role: String,
    });

    const roleMap = {
        admin: { label: 'Админ', severity: 'danger' },
        manager: { label: 'Менеджер', severity: 'info' },
        user: { label: 'Пользователь', severity: 'secondary' },
    };

    const mapped = computed(() => roleMap[props.role] ?? { label: props.role, severity: roleMap.user.severity });
</script>

<template>
    <Badge :value="mapped.label" :severity="mapped.severity" />
</template>
