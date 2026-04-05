<script setup>
    import {inject, ref} from "vue";
    import {X, CircleCheck} from "lucide-vue-next";
    import {Password, Button} from "primevue";
    import {changeUserPassword} from "../../api/users.js";
    import {useApi} from "../../composables/useApi.js";

    const dialogRef = inject('dialogRef');
    const { userId } = dialogRef.value.data;
    const { execute, loading } = useApi();

    const hide = () => dialogRef.value.close();

    const data = ref({
        password: null,
        password_confirmation: null,
    });

    const handleChangePassword = () => execute(
        async () => await changeUserPassword(userId, data.value),
        { successMessage: 'Пароль успешно обновлен', onSuccess: hide }
    );
</script>

<template>
    <div class="flex flex-col gap-6 p-6">
        <div class="flex justify-between">
            <span class="font-bold text-xl">Сменить пароль</span>
            <X size="24" class="cursor-pointer opacity-75 hover:opacity-100" @click="hide" />
        </div>
        <div class="grid grid-cols-1 gap-3">
            <div class="flex flex-col">
                <label class="form-label" for="newPassword">Новый пароль</label>
                <Password toggle-mask fluid input-id="newPassword" :feedback="false" v-model="data.password" placeholder="Новый пароль" />
            </div>
            <div class="flex flex-col">
                <label class="form-label" for="newPasswordConfirmation">Подтвердите пароль</label>
                <Password fluid input-id="newPasswordConfirmation" :feedback="false" v-model="data.password_confirmation" placeholder="Подтвердите пароль" />
            </div>
        </div>
        <Button label="Сохранить" fluid :loading="loading" @click="handleChangePassword">
            <template #icon><CircleCheck size="14"/></template>
        </Button>
    </div>
</template>
