<script setup>
    import {useRoute} from "vue-router";
    import {useMessageStore} from "../stores/useMessageStore.js";
    import {ref, watch} from "vue";
    import {storeToRefs} from "pinia";
    import {useConversationStore} from "../stores/useConversationStore.js";
    import ChatHeader from "../components/Chat/ChatHeader.vue";
    import ChatMessages from "../components/Chat/ChatMessages.vue";

    const route = useRoute();

    const messageStore = useMessageStore();
    const conversationStore = useConversationStore();

    const { messages } = storeToRefs(messageStore);

    const conversation = ref();

    watch(() => route.params.id, async conversationId => {
        if (conversationId) {
            conversation.value = await conversationStore.loadOne(conversationId);
            await messageStore.load(conversationId);
        }
    }, { immediate: true });
</script>

<template>
    <div class="flex grow size-full">
        <div class="flex flex-col size-full">
            <ChatHeader :conversation="conversation" />
            <ChatMessages :messages="messages" />
        </div>
    </div>
</template>
