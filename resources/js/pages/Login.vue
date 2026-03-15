<script setup>
    import { Layers } from 'lucide-vue-next';
    import { InputText, Password, Checkbox, Button, Message } from "primevue";
    import { Form } from "@primevue/forms"
    import { ref } from "vue";
    import { z } from 'zod'
    import { zodResolver } from '@primevue/forms/resolvers/zod'
    import { useAuthStore } from "../stores/auth.js";

    const resolver = zodResolver(
        z.object({
            email: z.string().email('Email неккоректный'),
            password: z.string().min(8, 'Пароль слишком короткий')
        })
    );

    const remember = ref(false);
    const loading = ref(false);
    const authStore = useAuthStore();

    async function auth({ valid, values }) {
        if (!valid) {
            return;
        }

        const data = { ...values, remember: remember.value };
        await authStore.login(data);
    }
</script>

<template>
    <div class="min-h-screen flex items-center justify-center bg-surface-900">
        <div class="flex flex-col gap-8">
            <div class="flex flex-col items-center gap-4 mx-20">
                <Layers size="40" />
                <span class="text-2xl font-bold tracking-tight">Войдите в свой аккаунт</span>
            </div>
            <Form class="px-6 py-8 rounded-xl flex flex-col gap-4 shadow-sm bg-surface-950"
                  :resolver="resolver" v-slot="$form" @submit="auth" :initial-values="{remember: false}">
                <div class="flex flex-col gap-2 text-sm">
                    <label for="email">Email</label>
                    <InputText id="email" name="email" size="small" fluid placeholder="example@example.com" />
                    <Message v-if="$form.email?.invalid" severity="error" size="small" variant="simple">{{ $form.email.error?.message }}</Message>
                </div>
                <div class="flex flex-col gap-2 text-sm">
                    <label for="password">Пароль</label>
                    <Password id="password" size="small" name="password" toggleMask fluid :feedback="false" placeholder="Пароль" />
                    <Message v-if="$form.password?.invalid" severity="error" size="small" variant="simple">{{ $form.password.error?.message }}</Message>
                </div>
                <div class="flex items-center gap-2">
                    <Checkbox name="remember" inputId="remember_me" size="small" :binary="true" v-model="remember" />
                    <label for="remember_me" class="text-sm">Запомнить меня</label>
                </div>
                <Button type="submit" label="Войти" fluid size="small" title="Войти" :loading="loading" />
            </Form>
        </div>
    </div>
</template>
