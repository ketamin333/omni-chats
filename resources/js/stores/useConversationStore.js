import {ref} from "vue";
import {defineStore} from "pinia";
import {getConversation, getConversations} from "../api/conversations.js";

export const useConversationStore = defineStore('conversations', () => {
    const conversations = ref([]);
    const loading = ref(false);
    const total = ref(0);
    const page = ref(1);

    const load = async () => {
        loading.value = true;
        const response = (await getConversations(page.value)).data;

        conversations.value = response.data;
        total.value = response.meta.total;

        loading.value = false;
    };

    const loadOne = async (id) => {
        const existing = conversations.value.find(c => c.conversation_id === id)

        if (existing) {
            return existing;
        }

        return (await getConversation(id)).data;
    }

    return { conversations, loading, total, page, load, loadOne };
});
