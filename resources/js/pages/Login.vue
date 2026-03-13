<script setup>
import { Layers } from 'lucide-vue-next';
import { InputText, Password, Checkbox, Button } from "primevue";
import { ref } from "vue";

const email = ref('');
const password = ref('');
const remember = ref(false);

function submit() {
    console.log({ email: email.value, password: password.value, remember: remember.value });
}
</script>

<template>
    <div class="flex flex-col gap-8">
        <div class="flex flex-col items-center gap-4 mx-20">
            <Layers size="40" />
            <span class="text-2xl font-bold tracking-tight">Войдите в свой аккаунт</span>
        </div>
        <div class="bg-gray-100 dark:bg-gray-900 border border-gray-300 dark:border-gray-800 p-8 rounded-xl flex flex-col gap-4">
            <div class="flex flex-col gap-2 text-sm">
                <label for="email" class="text-gray-700 dark:text-gray-300">Email</label>
                <InputText id="email" size="small" v-model="email" fluid placeholder="example@example.com" />
            </div>
            <div class="flex flex-col gap-2 text-sm">
                <label for="password" class="text-gray-700 dark:text-gray-300">Пароль</label>
                <Password id="password" size="small" v-model="password" toggleMask fluid :feedback="false" placeholder="••••••••" />
            </div>
            <div class="flex items-center gap-2">
                <Checkbox v-model="remember" size="small" inputId="remember_me" :binary="true" />
                <label for="remember_me" class="text-sm text-gray-700 dark:text-gray-300">Запомнить меня</label>
            </div>
            <Button label="Войти" fluid @click="submit" size="small" />
        </div>
    </div>
</template>
