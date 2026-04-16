<script setup>
    import {IconField, InputIcon, InputText, Tag} from "primevue";
    import {Search} from "lucide-vue-next";
    import {useConversationStore} from "../stores/useConversationStore.js";
    import { storeToRefs } from "pinia";
    import {onMounted, ref} from "vue";
    import ConversationItem from "../components/Conversation/ConversationItem.vue";

    const store = useConversationStore();
    const { conversations, activeConversation } = storeToRefs(store);
    const { load, loadMore, total } = store;

    const sentinel = ref(null);

    onMounted(() => {
        load();

        const observer = new IntersectionObserver(([entry]) => {
            if (entry.isIntersecting) {
                loadMore();
            }
        });

        observer.observe(sentinel.value);
    });
</script>

<template>
    <div class="grid h-full grid-cols-12">
        <div class="col-span-3 border-surface border-r flex flex-col">
            <div class="flex items-center">
                <span class="text-color font-bold text-2xl p-4">Чаты</span>
                <Tag :value="total" />
            </div>
<!--            <IconField>-->
<!--                <InputIcon><Search size="14" /></InputIcon>-->
<!--                <InputText placeholder="Поиск..." fluid type="text" as="button" />-->
<!--            </IconField>-->
            <div class="flex flex-col">
                <ConversationItem
                    v-for="conversation in conversations"
                    :conversation="conversation"
                />
            </div>
            <div ref="sentinel" class="h-1" />
        </div>
        <div class="col-span-9">
            <div v-if="activeConversation">
                {{ activeConversation.conversation_id }}
            </div>
            <div v-else class="flex items-center justify-center h-full text-muted-color">
                Выберите диалог
            </div>
        </div>
    </div>
</template>
