<script setup>

    import {IconField, InputIcon, InputText} from "primevue";
    import {Search} from "lucide-vue-next";
</script>

<template>
    <div class="grid h-full grid-cols-12">
        <div class="col-span-3 p-4 border-surface border-r flex flex-col gap-4">
            <span class="text-color font-bold text-2xl">Чаты</span>
            <IconField>
                <InputIcon><Search size="14" /></InputIcon>
                <InputText placeholder="Поиск..." fluid type="text" as="button" />
            </IconField>
            <div class="flex flex-col">

            </div>
        </div>
        <div class="col-span-9">

        </div>
    </div>
</template>
