<script setup>
    import {Avatar} from "primevue";
    import dayjs from "../../config/dayjs.js";
    import {useConversationStore} from "../../stores/useConversationStore.js";

    const props = defineProps({
        conversation: Object
    });

    const store = useConversationStore();

    const { contact, last_message } = props.conversation;
    const label = (contact.username ?? contact.phone ?? '?').charAt(0).toUpperCase();

    const onConversationClick = () => store.setActive(props.conversation)
</script>

<template>
    <div class="flex p-4 items-center gap-3" @click="onConversationClick">
        <Avatar :label="label" shape="circle" size="large" class="shrink-0" />
        <div class="flex flex-col grow">
            <div class="flex justify-between">
                <span class="text-base font-semibold">{{ contact.username }}</span>
                <span class="text-base text-muted-color">
                    {{ last_message ? dayjs.unix(last_message.timestamps.created_at).format('HH:mm') : '' }}
                </span>
            </div>
            <div class="text-sm text-muted-color">{{ last_message?.text }}</div>
        </div>
    </div>
</template>
