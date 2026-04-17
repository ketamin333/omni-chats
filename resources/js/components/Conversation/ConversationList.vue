<script setup>
    import ConversationItem from "./ConversationItem.vue";
    import {Tag} from "primevue";
    import {storeToRefs} from "pinia";
    import {onMounted, onUnmounted, ref} from "vue";
    import {useConversationStore} from "../../stores/useConversationStore.js";
    import {useChatsChannel} from '../../composables/useChatsChannel.js';

    const store = useConversationStore();

    const { load, updateLastMessage } = store;
    const { subscribe, unsubscribe } = useChatsChannel(message => updateLastMessage(message));
    const { conversations, total } = storeToRefs(store);

    onMounted(() => {
        load();
        subscribe();
    });

    onUnmounted(() => unsubscribe());
</script>

<template>
    <div class="flex items-center">
        <span class="text-color font-bold text-2xl p-4">Чаты</span>
        <Tag :value="total" />
    </div>
    <div class="flex flex-col">
        <ConversationItem
            v-for="conversation in conversations"
            :conversation="conversation"
        />
    </div>
</template>
