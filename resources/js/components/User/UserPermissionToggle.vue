<script setup>
    import {onMounted, ref} from "vue";
    import {getPermissions} from "../../api/permissions.js";
    import {ToggleSwitch} from "primevue";

    const permissions = ref([]);

    onMounted(() => loadPermissions());

    const props = defineProps({ active: Array });
    const emit = defineEmits(['update:active']);

    const loadPermissions = async () => permissions.value = (await getPermissions()).data;

    const onChange = (state, slug) => {
        const updated = state
            ? [...props.active, slug]
            : props.active.filter(i => i !== slug);

        emit('update:active', updated);
    }
</script>

<template>
    <div class="flex flex-col gap-3">
        <div v-for="{ slug, label, description } in permissions" class="flex items-start gap-2">
            <ToggleSwitch @update:model-value="state => onChange(state, slug)" :model-value="active.includes(slug)" />
            <label class="flex flex-col">
                <span class="font-semibold text-base">{{ label }}</span>
                <span class="text-muted-color">{{ description }}</span>
            </label>
        </div>
    </div>
</template>
