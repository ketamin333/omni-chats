<script setup>
    import {Button, DataTable, Tag, Column, Avatar} from "primevue";
    import {CalendarPlus, MessageCirclePlus, Layers, Router, CircleDotDashed, MousePointerClick, Trash2, SquarePen} from "lucide-vue-next";
    import {onMounted, onUnmounted, ref} from "vue";
    import {useDialog} from "primevue/usedialog";
    import CreateChannelDialog from "../components/Channel/CreateChannelDialog.vue";
    import {useChannelsChannel} from "../composables/useChannelsChannel.js";
    import {getChannels} from "../api/channels.js";
    import {adapterTypesConfig, adapterNamesConfig} from "../config/adapterConfig.js";
    import dayjs from "../config/dayjs.js";
    import {channelStatus} from "../config/channelConfig.js";

    const dialog = useDialog();
    const total = ref(0);
    const channels = ref([]);
    const loading = ref(false);
    const perPage = 25;
    const page = ref(1);

    const { subscribe, unsubscribe } = useChannelsChannel(channels, total);

    onMounted(() => { loadChannels(); subscribe(); });
    onUnmounted(() => unsubscribe());

    const loadChannels = async () => {
        loading.value = true;
        const response = (await getChannels(page.value)).data;

        total.value = response.meta.total;
        channels.value = response.data;
        loading.value = false;
    };

    const onPage = e => {
        page.value = e.page + 1;
        loadChannels();
    };

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
            :value="channels"
            :loading="loading"
            paginator
            :total-records="total"
            :rows="perPage"
            @page="onPage"
        >
            <template #header>
                <div class="shrink-0 flex justify-between items-start">
                    <div class="flex flex-col">
                        <div class="flex gap-2 items-center">
                            <span class="text-color font-bold text-2xl">Каналы</span>
                            <Tag :value="total" />
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
            <Column header="Канал" field="channel_name">
                <template #header>
                    <Layers size="14" />
                </template>
                <template #body="{data: { channel_name }}">
                    <span class="font-medium text-color">{{ channel_name }}</span>
                </template>
            </Column>
            <Column header="Адаптер" field="channel_name">
                <template #header>
                    <Router size="14" />
                </template>
                <template #body="{data: { adapter: { adapter_name, adapter_type } }}">
                    <Tag :value="adapterNamesConfig[adapter_name].slugs[adapter_type]?.label"
                         :severity="adapterNamesConfig[adapter_name].tagSeverity || 'contrast'" />
                </template>
            </Column>
            <Column header="Статус" field="status">
                <template #header>
                    <CircleDotDashed size="14" />
                </template>
                <template #body="{data: { status }}">
                    <span class="text-muted-color">
                        <Tag :value="channelStatus[status].label" :severity="channelStatus[status].severity">
                            <template #icon>
                                <component size="12" :is="channelStatus[status].icon || ''" />
                            </template>
                        </Tag>
                    </span>
                </template>
            </Column>
            <Column header="Создан" field="created_at">
                <template #header>
                    <CalendarPlus size="14" />
                </template>
                <template #body="{data: { timestamps: { created_at } }}">
                    <span class="text-muted-color">
                        {{ dayjs.unix(created_at).format('DD/MM/YYYY') }}
                    </span>
                </template>
            </Column>
            <Column header="Действия">
                <template #header>
                    <MousePointerClick size="14" />
                </template>
                <template #body="{data: { channel_id }}">
                    <div class="flex gap-2">
                        <Button outlined rounded
                                v-tooltip.bottom="'Изменить'">
                            <template #icon>
                                <SquarePen size="14" />
                            </template>
                        </Button>
                    </div>
                </template>
            </Column>
        </DataTable>
    </div>

</template>
