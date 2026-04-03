<script setup>
    import { Layers } from 'lucide-vue-next';
    import { InputText, Password, Checkbox, Button, Message } from "primevue";
    import { ref } from "vue";
    import { useAuthStore } from "../stores/auth.js";

    const authStore = useAuthStore();
    const loading = ref(false);
    const error = ref(null);

    const data = ref({
        email: null,
        password: null,
        remember: false,
    });

    const auth = async () => {
        loading.value = true;

        try {
            await authStore.login(data.value);
            window.location.href = '/';
        } catch (e) {
            error.value = e.response?.data?.message ?? 'Ошибка авторизации';
        } finally {
            loading.value = false;
        }
    };
</script>

<template>
    <div class="w-full h-full flex items-center justify-center bg-surface-100">
        <div class="flex flex-col gap-8">
            <div class="flex flex-col items-center gap-4 mx-20">
                <Layers size="40" />
                <span class="text-2xl font-bold tracking-tight">Войдите в свой аккаунт</span>
            </div>
            <div class="p-6 rounded-xl flex flex-col gap-4 shadow-sm bg-surface-0">
                <div class="flex flex-col">
                    <label for="email" class="form-label">Email</label>
                    <InputText id="email" v-model="data.email" name="email" fluid placeholder="example@example.com" />
                </div>
                <div class="flex flex-col">
                    <label for="password" class="form-label">Пароль</label>
                    <Password id="password" v-model="data.password" name="password" toggleMask fluid :feedback="false" placeholder="Пароль" />
                </div>
                <div class="flex items-center gap-2">
                    <Checkbox name="remember" inputId="remember_me" :binary="true" v-model="data.remember" />
                    <label for="remember_me" class="text-base">Запомнить меня</label>
                </div>
                <Button type="submit" label="Войти" @click="auth" class="mt-4" fluid title="Войти" :loading="loading" />
                <Message v-if="error" severity="error" class="justify-center" variant="simple">{{ error }}</Message>
            </div>
        </div>
    </div>
</template>
