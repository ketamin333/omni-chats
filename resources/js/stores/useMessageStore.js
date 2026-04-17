import {defineStore} from "pinia";
import {ref} from "vue";
import {getMessages} from "../api/messages.js";

export const useMessageStore = defineStore('messages', () => {
    const messages = ref([]);
    const loading = ref(false);
    const nextCursor = ref();
    const hasMore = ref(false);
    const conversationId = ref();

    const load = async id => {
        conversationId.value = id;
        loading.value = true;

        const response = (await getMessages(id)).data;

        messages.value = response.data.reverse();
        nextCursor.value = response.meta.next_cursor;
        hasMore.value = response.meta.has_more;

        loading.value = false;
    };

    const addMessage = message => messages.value.push(message);

    return { messages, load, loading, addMessage };
});
