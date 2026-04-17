import { defineStore } from "pinia";
import { ref } from "vue";
import { getMessages } from "@/api/messages";
import { Message } from "@/types/message";

export const useMessageStore = defineStore('messages', () => {
    const messages = ref<Message[]>([]);
    const loading = ref(false);
    const nextCursor = ref<string | null>(null);
    const hasMore = ref(false);
    const conversationId = ref<string | null>(null);

    const load = async (id: string) => {
        conversationId.value = id;
        loading.value = true;

        const response = (await getMessages(id)).data;

        messages.value = response.data.reverse();
        nextCursor.value = response.meta.next_cursor;
        hasMore.value = response.meta.has_more;

        loading.value = false;
    };

    const addMessage = (message: Message) => messages.value.push(message);

    return { messages, load, loading, hasMore, nextCursor, conversationId, addMessage };
});
