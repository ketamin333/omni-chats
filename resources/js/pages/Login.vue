<script setup>
    import { Layers } from 'lucide-vue-next';
    import { InputText, Password, Checkbox, Button, Message } from "primevue";
    import { Form, FormField } from "@primevue/forms"
    import { ref } from "vue";
    import { z } from 'zod'
    import { zodResolver } from '@primevue/forms/resolvers/zod'
    import { useAuthStore } from "../stores/auth.js";

    const resolver = zodResolver(
        z.object({
            email: z.string().email('Email неккоректен'),
            password: z.string()
        })
    );

    const remember = ref(false);
    const loading = ref(false);
    const error = ref(null);

    const authStore = useAuthStore();

    async function auth({ valid, values, errors }) {
        try {
            if (!valid) {
                return error.value = Object.values(errors).flat().map(e => e.message)[0];
            }

            loading.value = true;

            const data = { ...values, remember: remember.value };

            await authStore.login(data);
            window.location.href = '/';
        } catch (e) {
            error.value = e.response?.data?.message ?? 'Произошла ошибка';
        } finally {
            loading.value = false;
        }
    }
</script>

<template>
    <div class="w-full h-full flex items-center justify-center bg-surface-100">
        <div class="flex flex-col gap-8">
            <div class="flex flex-col items-center gap-4 mx-20">
                <Layers size="40" />
                <span class="text-2xl font-bold tracking-tight">Войдите в свой аккаунт</span>
            </div>
            <Form class="px-6 py-8 rounded-xl flex flex-col gap-4 shadow-sm bg-surface-0" @submit="auth" v-slot="$form"
                  :resolver="resolver"
                  :validate-on-blur="false"
                  :validate-on-value-update="false"
                  :validate-on-submit="true"
                  :initial-values="{remember: false}">
                <FormField class="flex flex-col gap-2 text-sm">
                    <label for="email">Email</label>
                    <InputText id="email" name="email" size="small" fluid placeholder="example@example.com" />
                </FormField>
                <FormField class="flex flex-col gap-2 text-sm">
                    <label for="password">Пароль</label>
                    <Password id="password" size="small" name="password" toggleMask fluid :feedback="false" placeholder="Пароль" />
                </FormField>
                <div class="flex items-center gap-2">
                    <Checkbox name="remember" inputId="remember_me" size="small" :binary="true" v-model="remember" />
                    <label for="remember_me" class="text-sm">Запомнить меня</label>
                </div>
                <Message v-if="error" severity="error" size="small" variant="simple" class="justify-center">{{ error }}</Message>
                <Button type="submit" label="Войти" fluid size="small" title="Войти" :loading="loading" />
            </Form>
        </div>
    </div>
</template>
