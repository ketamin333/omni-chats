<script setup>
  import {onMounted} from "vue";
  import Sidebar from "../components/sidebar/Sidebar.vue";
  import {useAuthStore} from "../stores/auth.js";

  const authStore = useAuthStore();

  onMounted(async () => {
      await authStore.fetchUser();
  });
</script>

<template>
    <div class="bg-surface-50 h-full w-full flex gap-2 p-2">
        <aside class="w-60 shrink-0">
            <Sidebar />
        </aside>
        <section class="flex-1 min-w-0 bg-surface-0 rounded-xl shadow-sm">
            <RouterView />
        </section>
    </div>
</template>

<style scoped>

</style>
