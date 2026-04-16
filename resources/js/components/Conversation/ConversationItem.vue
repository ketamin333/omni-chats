<script setup>
    import {Avatar} from "primevue";
    import dayjs from "../../config/dayjs.js";
    import {messageStatus} from "../../config/messageConfig.js";

    const props = defineProps({ conversation: Object });

    const { contact, last_message: lastMessage = null, conversation_id: conversationId } = props.conversation;
    const { username } = contact;
    const { text = null, status, timestamps: { created_at: messageCreatedUnix = null } } = lastMessage;
</script>

<template>
    <RouterLink class="flex items-center gap-3 p-4" :to="{ name: 'chats.detail', params: { id: conversationId } }">
        <Avatar size="large" shape="circle" class="shrink-0" />
        <div class="flex flex-col grow min-w-0">
            <div class="flex justify-between text-base gap-4 grow">
                <span class="font-semibold text-color truncate">{{ username }}</span>
                <div class="flex gap-2 items-center">
                    <component :is="messageStatus[status].icon" size="14" />
                    <span class="text-muted-color">{{ dayjs.unix(messageCreatedUnix).format('HH:mm') }}</span>
                </div>
            </div>
            <span class="text-muted-color text-sm truncate grow">{{ text }}</span>
        </div>
    </RouterLink>
</template>
