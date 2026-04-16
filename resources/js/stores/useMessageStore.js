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
        console.log(response);

        messages.value = response.data.reverse();
        nextCursor.value = response.meta.next_cursor;
        hasMore.value = response.meta.has_more;

        loading.value = false;
    };

    return { messages, load, loading };
});
