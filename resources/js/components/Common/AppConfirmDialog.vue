<script setup>
    import {Button, ConfirmDialog} from "primevue";
    import {Trash2, TriangleAlert} from "lucide-vue-next";
</script>

<template>
    <ConfirmDialog>
        <template #container="{message, rejectCallback, acceptCallback}">
            <div class="flex flex-col gap-4 p-6">
                <div class="flex gap-4">
                    <span class="shrink-0 flex items-center justify-center rounded-full bg-red-100 text-red-500 size-12">
                        <TriangleAlert size="24" />
                    </span>
                    <div class="flex flex-col gap-2">
                        <span class="text-lg font-semibold text-color">{{ message?.header }}</span>
                        <span class="text-base text-muted-color">{{ message?.message }}</span>
                    </div>
                </div>
                <div class="flex justify-end gap-2">
                    <Button outlined @click="rejectCallback" :label="message?.rejectLabel || 'Отмена'" />
                    <Button severity="danger" @click="acceptCallback">
                        <Trash2 size="14" />
                        {{ message?.acceptLabel || 'Удалить' }}
                    </Button>
                </div>
            </div>
        </template>
    </ConfirmDialog>
</template>
