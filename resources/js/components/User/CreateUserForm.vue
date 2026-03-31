<script setup>
import { ref } from 'vue';
import { InputText, Select } from 'primevue';
import { Form, FormField } from '@primevue/forms';
import { UserRound, Plus } from 'lucide-vue-next';
import { zodResolver } from '@primevue/forms/resolvers/zod';
import { createUserSchema } from '../../validation/user.js';

const roles = [
    { name: 'Администратор', code: 'admin' },
    { name: 'Менеджер', code: 'manager' },
    { name: 'Пользователь', code: 'user' },
];

const initialValues = {
    username: '',
    email: '',
    password: '',
    password_confirmation: '',
    phone: '',
    role: 'user',
};

const resolver = zodResolver(createUserSchema);

const preview = ref(null);
const avatar = ref(null);

const onAvatarChange = (e) => {
    const file = e.target.files[0];
    if (!file) return;
    avatar.value = file;
    preview.value = URL.createObjectURL(file);
};

const emit = defineEmits(['submit']);

const onSubmit = ({ valid, values }) => {
    if (!valid) return;
    emit('submit', { ...values, avatar: avatar.value });
};

const formRef = ref(null);
defineExpose({ submit: () => formRef.value.$el.requestSubmit() });

</script>

<template>
    <Form ref="formRef" :resolver="resolver" :initial-values="initialValues" @submit="onSubmit" class="flex flex-col gap-4" v-slot="{ errors }"
          :validate-on-blur="false" :validate-on-submit="true" :validate-on-value-update="false">

        <div class="flex flex-col items-center gap-2">
            <div class="relative w-18 h-18 rounded-full bg-surface-50 border border-surface-300 border-dashed flex items-center justify-center cursor-pointer"
                 @click="$refs.fileInput.click()">
                <img v-if="preview" :src="preview" class="w-full h-full rounded-full object-cover" />
                <UserRound v-else class="text-muted-color" />
                <div class="absolute bottom-0 right-0 w-5 h-5 rounded-full bg-primary flex items-center justify-center">
                    <Plus size="12" class="text-surface-0" />
                </div>
                <input ref="fileInput" type="file" accept="image/*" class="hidden" @change="onAvatarChange" />
            </div>
            <span class="text-xs text-muted-color font-medium">PNG, JPG до 2MB</span>
        </div>

        <div class="grid grid-cols-2 gap-3">
            <FormField name="username" class="col-span-1" v-slot="{ value, error, onInput }">
                <label class="required">Имя пользователя</label>
                <InputText :value="value" @input="onInput" fluid size="small" placeholder="Имя пользователя" :invalid="!!error" />
            </FormField>

            <FormField name="email" class="col-span-1" v-slot="{ value, error, onInput }">
                <label class="required">Email</label>
                <InputText :value="value" @input="onInput" fluid size="small" placeholder="email@example.com" :invalid="!!error" />
            </FormField>

            <FormField name="password" class="col-span-1" v-slot="{ value, error, onInput }">
                <label class="required">Пароль</label>
                <InputText :value="value" @input="onInput" type="password" fluid size="small" placeholder="Пароль" :invalid="!!error" />
            </FormField>

            <FormField name="password_confirmation" class="col-span-1" v-slot="{ value, error, onInput }">
                <label class="required">Подтвердите пароль</label>
                <InputText :value="value" @input="onInput" type="password" fluid size="small" placeholder="Подтвердите пароль" :invalid="!!error" />
            </FormField>

            <FormField name="phone" class="col-span-1" v-slot="{ value, error, onInput }">
                <label>Номер телефона</label>
                <InputText :value="value" @input="onInput" fluid size="small" placeholder="+7 (999) 000-00-00" :invalid="!!error" />
            </FormField>

            <FormField name="role" class="col-span-1" v-slot="{ value, error, onChange }">
                <label class="required">Роль</label>
                <Select :model-value="value" @update:model-value="onChange" :options="roles"
                        option-label="name" option-value="code"
                        :checkmark="true" :highlight-on-select="false"
                        fluid size="small" :invalid="!!error" />
            </FormField>
        </div>

        <pre>{{ errors }}</pre>

        <div v-if="errors && Object.keys(errors).length" class="flex flex-col gap-1">
            <small v-for="(error, field) in errors" :key="field" class="text-red-400 text-xs">
                {{ error?.[0]?.message }}
            </small>
        </div>

        <slot name="footer" />
    </Form>
</template>
