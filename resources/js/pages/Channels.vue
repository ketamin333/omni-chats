<script setup>
    import {Button, DataTable, IconField, InputIcon, InputText, Tag} from "primevue";
    import {MessageCirclePlus} from "lucide-vue-next";
    import {ref} from "vue";
    import {useDialog} from "primevue/usedialog";
    import CreateChannelDialog from "../components/Channel/CreateChannelDialog.vue";

    const dialog = useDialog();

    const total = ref(0);

    const onCreateChannelClick = () => dialog.open(CreateChannelDialog, {
        props: {
            modal: true,
            showHeader: false,
            class: 'w-[38rem]'
        },
    });
</script>

<template>
    <div class="flex flex-col h-full overflow-hidden pt-1 pb-2 text-base">
        <DataTable
            scrollable
            scrollHeight="flex"

        >
            <template #header>
                <div class="shrink-0 flex justify-between items-start">
                    <div class="flex flex-col">
                        <div class="flex gap-2 items-center">
                            <span class="text-color font-bold text-2xl">Каналы</span>
                            <Tag :value="total"></Tag>
                        </div>
                        <span class="text-muted-color text-base">Добавляйте новые каналы связи</span>
                    </div>
                    <div class="flex gap-2">
                        <Button label="Добавить" @click="onCreateChannelClick">
                            <template #icon><MessageCirclePlus size="14" /></template>
                        </Button>
                    </div>
                </div>
            </template>
        </DataTable>
    </div>

</template>
