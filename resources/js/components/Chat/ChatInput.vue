<script setup>
    import {Textarea, Button} from "primevue";
    import {Plus, ArrowUp} from "lucide-vue-next";
    import {ref, watch} from "vue";
    import {sendMessage} from "../../api/messages.js";

    const text = ref();
    const textarea = ref();
    const loading = ref(false);

    watch(text, () => textarea.value.$el.style.height = 'auto');

    const props = defineProps({ conversation: Object });

    const onSendClick = async () => {
        if (!text.value) {
           return;
        }

        loading.value = true;

        const message = (await sendMessage(props.conversation.conversation_id, { text: text.value })).data;

        text.value = null;
        loading.value = false;
    };
</script>

<template>
    <div class="p-4 flex flex-col bg-surface-0 rounded-xl shadow-sm gap-3">
        <div class="max-h-30 overflow-y-auto">
            <Textarea
                ref="textarea" @keydown.enter.exact.prevent="onSendClick"
                v-model="text" auto-resize
                fluid rows="1" placeholder="Сообщение"
                class="!border-0 !p-0 !rounded-none !shadow-none"
            />
        </div>
        <div class="flex justify-between items-center">
            <Button size="small" rounded variant="text">
                <template #icon><Plus size="14" class="shrink-0" /></template>
            </Button>
            <Button size="small" rounded @click="onSendClick" :loading="loading">
                <template #icon><ArrowUp size="14" class="shrink-0" /></template>
            </Button>
        </div>
    </div>
</template>
