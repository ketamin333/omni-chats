<script setup>
    import {useRoute} from "vue-router";
    import {useMessageStore} from "../stores/useMessageStore.js";
    import {ref, watch} from "vue";
    import {storeToRefs} from "pinia";
    import {useConversationStore} from "../stores/useConversationStore.js";
    import ChatHeader from "../components/Chat/ChatHeader.vue";
    import ChatMessages from "../components/Chat/ChatMessages.vue";
    import {useConversationChannel} from '../composables/useConversationChannel.js';
    import ChatInput from "../components/Chat/ChatInput.vue";

    const route = useRoute();

    const messageStore = useMessageStore();
    const conversationStore = useConversationStore();

    const { messages } = storeToRefs(messageStore);

    const conversation = ref();
    let channel = null;

    watch(() => route.params.id, async conversationId => {
        if (channel) {
            channel.unsubscribe();
        }

        if (conversationId) {
            conversation.value = await conversationStore.loadOne(conversationId);
            await messageStore.load(conversationId);

            channel = useConversationChannel(conversationId, msg => messageStore.addMessage(msg));
            channel.subscribe();
        }
    }, { immediate: true });
</script>

<template>
    <div class="flex grow size-full">
        <div class="flex flex-col size-full">
            <ChatHeader :conversation="conversation" />
            <div class="grow bg-surface-50 flex flex-col min-h-0">
                <div class="max-w-4xl mx-auto size-full flex flex-col pb-4">
                    <ChatMessages :messages="messages" />
                    <ChatInput :conversation="conversation" />
                </div>
            </div>
        </div>
    </div>
</template>
