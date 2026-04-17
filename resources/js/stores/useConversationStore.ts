import {ref} from "vue";
import {defineStore} from "pinia";
import {getConversation, getConversations} from "@/api/conversations";
import {Conversation} from "@/types/conversation";
import {Message} from "@/types/message";

export const useConversationStore = defineStore('conversations', () => {
    const conversations = ref<Conversation[]>([]);
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

    const loadOne = async (id: string): Promise<Conversation> => {
        const existing = conversations.value.find(c => c.conversation_id === id);

        if (existing) {
            return existing;
        }

        return (await getConversation(id)).data;
    };

    const updateLastMessage = (message: Message) => {
        const index = conversations.value.findIndex(c => c.conversation_id === message.conversation_id);

        if (index !== -1) {
            conversations.value[index] = {
                ...conversations.value[index],
                last_message: message
            };
            conversations.value.unshift(conversations.value.splice(index, 1)[0]);
        }
    };

    return { conversations, loading, total, page, load, loadOne, updateLastMessage };
});
