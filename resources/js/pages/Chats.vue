<script setup>
    import ConversationList from "../components/Conversation/ConversationList.vue";
</script>

<template>
    <div class="grid h-full grid-cols-12">
        <div class="col-span-3 border-surface border-r flex flex-col">
            <ConversationList />
        </div>
        <div class="col-span-9">
            <RouterView />
        </div>
    </div>
</template>
