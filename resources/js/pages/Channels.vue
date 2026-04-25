<script setup lang="ts">
    import { Button, DataTable, Tag, Column } from 'primevue'
    import {
        CalendarPlus, MessageCirclePlus, Layers, Router,
        CircleDotDashed, MousePointerClick, Trash2, SquarePen
    } from 'lucide-vue-next'
    import { onMounted, onUnmounted } from 'vue'
    import { useDialog } from 'primevue/usedialog'
    import { useToast } from 'primevue/usetoast'
    import { useConfirm } from 'primevue/useconfirm'
    import CreateChannelDialog from '@/components/Channel/CreateChannelDialog.vue'
    import UpdateChannelDialog from '@/components/Channel/UpdateChannelDialog.vue'
    import { useChannelsChannel } from '@/composables/useChannelsChannel'
    import { useChannelStore } from '@/stores/useChannelStore'
    import { adapterNamesConfig } from '@/config/adapterConfig'
    import { channelStatus } from '@/config/channelConfig'
    import dayjs from '@/config/dayjs'

    const dialog = useDialog()
    const toast = useToast()
    const confirm = useConfirm()

    const store = useChannelStore()
    const { subscribe, unsubscribe } = useChannelsChannel(store.channels, store.total)

    onMounted(() => { store.load(); subscribe() })
    onUnmounted(() => unsubscribe())

    const onCreateChannelClick = () => dialog.open(CreateChannelDialog, {
        props: { modal: true, showHeader: false, class: 'w-[38rem]' },
    })

    const onUpdateChannelClick = (channelId: string) => dialog.open(UpdateChannelDialog, {
        props: { modal: true, showHeader: false, class: 'w-[38rem]' },
        data: { channelId },
    })

    const onDeleteChannelClick = (channelId: string) => confirm.require({
        message: 'Канал будет помечен как удалённый и скрыт из активного списка',
        header: 'Вы действительно хотите удалить канал?',
        accept: async () => {
            try {
                await store.remove(channelId)
                toast.add({ severity: 'success', summary: 'Канал успешно удален' })
            } catch (e: any) {
                toast.add({ severity: 'error', summary: e.message, detail: e.errors })
            }
        },
    })
</script>

<template>
    <div class="flex flex-col h-full overflow-hidden pb-2 text-base">
        <DataTable
            scrollable
            scrollHeight="flex"
            :value="store.channels"
            :loading="store.loading"
            paginator
            :total-records="store.total"
            :rows="store.perPage"
            @page="store.onPage"
            lazy
        >
            <template #header>
                <div class="shrink-0 flex justify-between items-start">
                    <div class="flex flex-col">
                        <div class="flex gap-2 items-center">
                            <span class="text-color font-bold text-2xl">Каналы</span>
                            <Tag :value="store.total" />
                        </div>
                        <span class="text-muted-color text-base">Добавляйте новые каналы связи</span>
                    </div>
                    <Button label="Добавить" @click="onCreateChannelClick">
                        <template #icon><MessageCirclePlus size="14" /></template>
                    </Button>
                </div>
            </template>

            <Column field="channel_name">
                <template #header><Layers size="14" /></template>
                <template #body="{ data }">
                    <span class="font-medium text-color">{{ data.channel_name }}</span>
                </template>
            </Column>

            <Column field="adapter">
                <template #header><Router size="14" /></template>
                <template #body="{ data }">
                    <Tag
                        :value="adapterNamesConfig[data.adapter.adapter_name].slugs[data.adapter.adapter_type]?.label"
                        :severity="adapterNamesConfig[data.adapter.adapter_name].tagSeverity || 'contrast'"
                    />
                </template>
            </Column>

            <Column field="status">
                <template #header><CircleDotDashed size="14" /></template>
                <template #body="{ data }">
                    <Tag :value="channelStatus[data.status].label" :severity="channelStatus[data.status].severity">
                        <template #icon>
                            <component :is="channelStatus[data.status].icon" size="12" />
                        </template>
                    </Tag>
                </template>
            </Column>

            <Column field="created_at">
                <template #header><CalendarPlus size="14" /></template>
                <template #body="{ data }">
                    <span class="text-muted-color">
                        {{ dayjs.unix(data.timestamps.created_at).format('DD/MM/YYYY') }}
                    </span>
                </template>
            </Column>

            <Column>
                <template #header><MousePointerClick size="14" /></template>
                <template #body="{ data }">
                    <div class="flex gap-2">
                        <Button outlined rounded v-tooltip.bottom="'Изменить'"
                                @click="onUpdateChannelClick(data.channel_id)">
                            <template #icon><SquarePen size="14" /></template>
                        </Button>
                        <Button outlined rounded severity="danger" v-tooltip.bottom="'Удалить'"
                                @click="onDeleteChannelClick(data.channel_id)">
                            <template #icon><Trash2 size="14" /></template>
                        </Button>
                    </div>
                </template>
            </Column>
        </DataTable>
    </div>
</template>
