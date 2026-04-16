import { ref } from "vue";
import { defineStore } from "pinia";
import { getConversations } from "../api/conversations.js";

export const useConversationStore = defineStore('conversations', () => {
    const conversations = ref([]);
    const loading = ref(false);
    const total = ref(0);
    const page = ref(1);
    const activeConversation = ref(null);
    const setActive = (conversation) => activeConversation.value = conversation;

    const load = async () => {
        loading.value = true;

        const response = (await getConversations(page.value)).data;

        conversations.value = [...conversations.value, ...response.data];
        total.value = response.meta.total;
        loading.value = false;
    };

    const loadMore = async () => {
        if (loading.value) {
            return;
        }

        if (conversations.value.length >= total.value) {
            return;
        }

        if (conversations.value.length === 0) {
            return;
        }

        page.value++;
        await load();
    };

    return { conversations, loading, total, page, load, loadMore, activeConversation, setActive };
});
