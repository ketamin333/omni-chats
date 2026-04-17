<script setup>
    import { Avatar } from "primevue";
    import { computed } from "vue";

    const props = defineProps({ messages: Array });

    const groups = computed(() => {
        const result = [];
        let current = null;

        for (const message of props.messages) {
            if (!current || current.direction !== message.direction) {
                current = { direction: message.direction, messages: [] };
                result.push(current);
            }
            current.messages.push(message);
        }

        return result;
    });

    const isOutgoing = direction => direction === 'outgoing';

    const bubbleClass = (direction, index, total) => {
        const isLast = index === total - 1;
        const single = total === 1;

        if (isOutgoing(direction)) {
            return [
                'bg-primary text-primary-contrast px-4 py-2 text-sm max-w-sm',
                single || isLast ? 'rounded-2xl rounded-br-sm' : 'rounded-2xl',
            ];
        }

        return [
            'bg-surface-0 text-color px-4 py-2 text-sm max-w-sm',
            single || isLast ? 'rounded-2xl rounded-bl-sm' : 'rounded-2xl',
        ];
    };
</script>

<template>
    <div class="flex-1 flex overflow-y-auto justify-end gap-3 p-4 flex-col">
        <div
            v-for="group in groups"
            :key="group.messages[0].message_id"
            :class="isOutgoing(group.direction) ? 'flex-row-reverse' : 'flex-row'"
            class="flex items-end gap-2"
        >
            <Avatar shape="circle" class="shrink-0" />

            <div class="flex flex-col gap-1">
                <div
                    v-for="(message, index) in group.messages"
                    :key="message.message_id"
                    class="text-base"
                    :class="bubbleClass(group.direction, index, group.messages.length)"
                >
                    {{ message.text }}
                </div>
            </div>
        </div>
    </div>
</template>
