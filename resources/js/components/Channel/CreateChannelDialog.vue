<script setup>
    import {inject, onMounted, ref} from "vue";
    import {X, Wifi, Code, Check, Sun, ChevronRight, ChevronLeft} from "lucide-vue-next";
    import {Stepper, StepList, StepPanels, Step, StepPanel, Button, Divider, InputText} from 'primevue';
    import {createChannel} from "../../api/channels.js";
    import ChannelProviderCard from "./ChannelProviderCard.vue";
    import ChannelTypeCard from "./ChannelTypeCard.vue";
    import {useApi} from "../../composables/useApi.js";
    import {getAdapters} from "../../api/adapters.js";

    const dialogRef = inject('dialogRef');
    const activeStep = ref('1');
    const adapters = ref([]);

    onMounted(() => loadAdapters());

    const { execute, loading } = useApi();

    const channel = ref({
        provider_type_id: null,
        provider: {},
        type: {},
        channel_name: null,
        credentials: {},
    });

    const loadAdapters = async () => adapters.value = (await getAdapters()).data;

    const steps = [
        { value: '1', icon: Wifi },
        { value: '2', icon: Sun },
        { value: '3', icon: Code },
        { value: '4', icon: Check },
    ];

    const hide = () => dialogRef.value.close();

    const handleCreateChannel = async () => execute(
        // async () => await createChannel({
        //     channel_name: channel.value.channel_name,
        //     credentials: channel.value.credentials,
        // }),
    );
</script>

<template>
    <div class="flex p-6 flex-col">
        <div class="flex justify-between">
            <span class="font-bold text-xl">Создать канал</span>
            <X size="24" class="cursor-pointer opacity-75 hover:opacity-100" @click="hide" />
        </div>
        <Stepper value="1" linear v-model:value="activeStep">
            <StepList class="!gap-4 !py-6">
                <Step v-for="(step, index) in steps" :value="step.value"
                      as-child v-slot="{activateCallback, value, a11yAttrs}">
                    <div class="flex flex-col gap-2 justify-center" :class="{'w-full' : index < steps.length - 1}">
                        <div class="flex items-center gap-4">
                            <Button
                                @click="activateCallback"
                                :disabled="a11yAttrs?.header.disabled && activeStep < value"
                                rounded
                                :outlined="activeStep < value"
                                class="shrink-0"
                            >
                                <template #icon>
                                    <component :is="step.icon" size="14" />
                                </template>
                            </Button>
                            <Divider v-if="index < steps.length - 1" />
                        </div>
                    </div>
                </Step>
            </StepList>
            <StepPanels>
                <StepPanel value="1" as-child v-slot="{activateCallback}">
                    {{ adapters }}
                </StepPanel>
<!--                <StepPanel value="1" as-child v-slot="{activateCallback}">-->
<!--                    <div class="flex flex-col gap-6">-->
<!--                        <span class="text-muted-color">Выберите провайдера</span>-->
<!--                        <div class="grid grid-cols-2 items-center gap-4">-->
<!--                            <ChannelProviderCard :active="channel.provider" :providers="adapters" v-model:active="channel.provider" />-->
<!--                        </div>-->
<!--                        <div class="flex justify-end">-->
<!--                            <Button @click="activateCallback('2')" :disabled="!channel.provider">-->
<!--                                Далее <ChevronRight size="14" />-->
<!--                            </Button>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                </StepPanel>-->
<!--                <StepPanel value="2" as-child v-slot="{activateCallback}">-->
<!--                    <div class="flex flex-col gap-6">-->
<!--                        <div class="flex items-center gap-1 text-sm text-muted-color">-->
<!--                            <span class="flex items-center gap-1">-->
<!--                                <Wifi size="14" />-->
<!--                                <span class="font-medium">{{ channel.provider.name }}</span>-->
<!--                            </span>-->
<!--                            <ChevronRight size="10" />-->
<!--                            <span>Тип подключения</span>-->
<!--                        </div>-->
<!--                        <div class="grid grid-cols-2 items-center gap-4">-->
<!--                            <ChannelTypeCard-->
<!--                                :active="channel.type"-->
<!--                                :types="channel.provider.types"-->
<!--                                @update:active="providerType => { channel.provider_type_id = providerType.provider_type_id; channel.type = providerType }"-->
<!--                            />-->
<!--                        </div>-->
<!--                        <div class="flex justify-between">-->
<!--                            <Button outlined @click="activateCallback('1')">-->
<!--                                <ChevronLeft size="14" /> Назад-->
<!--                            </Button>-->
<!--                            <Button :disabled="!channel.type" @click="activateCallback('3')">-->
<!--                                Далее <ChevronRight size="14" />-->
<!--                            </Button>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                </StepPanel>-->
<!--                <StepPanel value="3" as-child v-slot="{activateCallback}">-->
<!--                    <div class="flex flex-col gap-6">-->
<!--                        <div class="flex items-center gap-1 text-sm text-muted-color">-->
<!--                            <span class="flex items-center gap-1">-->
<!--                                <Wifi size="14" />-->
<!--                                <span class="font-medium">{{ channel.provider.name }}</span>-->
<!--                            </span>-->
<!--                            <ChevronRight size="10" />-->
<!--                            <span class="font-medium">{{ channel.type.type?.name }}</span>-->
<!--                            <ChevronRight size="10" />-->
<!--                            <span>Настройка</span>-->
<!--                        </div>-->
<!--                        <div class="grid grid-cols-1 items-center gap-4">-->
<!--                            <div class="flex flex-col">-->
<!--                                <label class="form-label required" for="channelName">Название канала</label>-->
<!--                                <InputText placeholder="Название канала" id="channelName" required maxlength="255" v-model="channel.channel_name" />-->
<!--                            </div>-->
<!--                            <div v-for="field in channel.type?.settings_schema?.fields" :key="field.name" class="flex flex-col">-->
<!--                                <label class="form-label"-->
<!--                                       :class="{'required': field.required || false}">-->
<!--                                    {{ field.label }}-->
<!--                                </label>-->
<!--                                <InputText-->
<!--                                    v-model="channel.credentials[field.name]"-->
<!--                                    fluid-->
<!--                                    :required="field.required || false"-->
<!--                                    :placeholder="field.label"-->
<!--                                />-->
<!--                            </div>-->
<!--                        </div>-->
<!--                        <div class="flex justify-between">-->
<!--                            <Button outlined @click="activateCallback('2')">-->
<!--                                <ChevronLeft size="14" /> Назад-->
<!--                            </Button>-->
<!--                            <Button @click="handleCreateChannel(activateCallback('4'))" :loading="loading">-->
<!--                                Создать канал-->
<!--                            </Button>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                </StepPanel>-->
            </StepPanels>
        </Stepper>
    </div>
</template>
