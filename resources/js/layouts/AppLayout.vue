<script setup>
import {onMounted, onUnmounted} from "vue";
  import Sidebar from "../components/Sidebar/Sidebar.vue";
  import {useAuthStore} from "../stores/auth.js";
  import {DynamicDialog} from "primevue";
  import AppConfirmDialog from "../components/Common/AppConfirmDialog.vue";
  import AppToast from "../components/Common/AppToast.vue";
  import {useOnlineChannel} from "../composables/useOnlineChannel.js";

  const authStore = useAuthStore();
  const { subscribe: subscribeOnline, unsubscribe: unsubscribeOnline } = useOnlineChannel();

  onMounted(() => {
      authStore.fetchUser();
      subscribeOnline();
  });

  onUnmounted(() => unsubscribeOnline());
</script>

<template>
    <div class="bg-surface-50 h-full w-full flex gap-2 p-2">
        <aside class="w-60 shrink-0">
            <Sidebar />
        </aside>
        <section class="flex-1 min-w-0 bg-surface-0 rounded-xl shadow-sm grow overflow-hidden">
            <RouterView />
        </section>
    </div>

    <DynamicDialog />
    <AppToast />
    <AppConfirmDialog />
</template>
