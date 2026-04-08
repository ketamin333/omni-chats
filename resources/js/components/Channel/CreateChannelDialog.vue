<script setup>
    import {computed, inject, onMounted, ref} from "vue";
    import {X, Router, Code, Check, Sun, ChevronRight, ChevronLeft, Sparkles} from "lucide-vue-next";
    import {Stepper, StepList, StepPanels, Step, StepPanel, Button, Divider, InputText, Textarea} from 'primevue';
    import {createChannel} from "../../api/channels.js";
    import ChannelAdapterNameCard from "./ChannelAdapterNameCard.vue";
    import {useApi} from "../../composables/useApi.js";
    import {getAdapters} from "../../api/adapters.js";
    import ChannelAdapterTypeCard from "./ChannelAdapterTypeCard.vue";
    import {adapterNamesConfig, adapterTypesConfig} from "../../config/adapterConfig.js";
    import api from "../../api/axios.js";

    const dialogRef = inject('dialogRef');
    const activeStep = ref('1');
    const adapters = ref([]);

    onMounted(() => loadAdapters());

    const { execute, loading } = useApi();

    const channel = ref({
        adapter_id: null,
        channel_name: null,
        credentials: {},
        settings: {
            welcome_message: null,
        }
    });

    const selectedAdapter = ref(null);
    const selectedType = ref(null);

    const loadAdapters = async () => adapters.value = (await getAdapters()).data;

    const steps = [
        { value: '1', icon: Router },
        { value: '2', icon: Sun },
        { value: '3', icon: Code },
        { value: '4', icon: Sparkles },
        { value: '5', icon: Check },
    ];

    const hide = () => dialogRef.value.close();

    const grouped = computed(
        () => Object.values(adapters.value.reduce((acc, adapter) => {
            const { adapter_name, adapter_type, adapter_id, is_enabled, slug } = adapter;

            if (!is_enabled) {
                return acc;
            }

            acc[adapter_name] ??= { adapter_name, types: [] };
            acc[adapter_name].types.push({ adapter_type, adapter_id, slug });

            return acc;
        }, {}))
    );

    const selectAdapter = name => {
        selectedAdapter.value = grouped.value.find(a => a.adapter_name === name);
        selectedType.value = null;
        channel.value.adapter_id = null;
    };

    const selectType = adapterId => {
        channel.value.adapter_id = adapterId;
        selectedType.value = adapters.value.find(a => a.adapter_id === adapterId);
    };

    const handleCreateChannel = () => execute(
        async () => await createChannel(channel.value),
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
                    <div class="flex flex-col gap-6">
                        <span class="text-muted-color">Выберите адаптер</span>
                        <div class="grid grid-cols-2 items-center gap-4">
                            <ChannelAdapterNameCard
                                :adapters="grouped"
                                @update:active="selectAdapter"
                                :active="selectedAdapter?.adapter_name"
                            />
                        </div>
                        <div class="flex justify-end">
                            <Button @click="activateCallback('2')" :disabled="!selectedAdapter">
                                Далее <ChevronRight size="14" />
                            </Button>
                        </div>
                    </div>
                </StepPanel>
                <StepPanel value="2" as-child v-slot="{activateCallback}">
                    <div class="flex flex-col gap-6">
                        <div class="flex items-center gap-1 text-sm text-muted-color">
                            <span class="flex items-center gap-1">
                                <Router size="14" />
                                <span class="font-medium">{{ adapterNamesConfig[selectedAdapter?.adapter_name]?.label }}</span>
                            </span>
                            <ChevronRight size="10" />
                            <span>Выберите тип</span>
                        </div>
                        <div class="grid grid-cols-2 items-center gap-4">
                            <ChannelAdapterTypeCard
                                :adapter="selectedAdapter"
                                @update:active="selectType"
                                :active="channel.adapter_id"
                            />
                        </div>
                        <div class="flex justify-between">
                            <Button outlined @click="activateCallback('1')">
                                <ChevronLeft size="14" /> Назад
                            </Button>
                            <Button @click="activateCallback('3')" :disabled="!channel.adapter_id" >
                                Далее <ChevronRight size="14" />
                            </Button>
                        </div>
                    </div>
                </StepPanel>
                <StepPanel value="3" as-child v-slot="{activateCallback}">
                    <div class="flex flex-col gap-6">
                        <div class="flex items-center gap-1 text-sm text-muted-color">
                            <span class="flex items-center gap-1">
                                <Router size="14" />
                                <span class="font-medium">{{ adapterNamesConfig[selectedAdapter?.adapter_name]?.label }}</span>
                            </span>
                            <ChevronRight size="10" />
                            <span class="font-medium">{{ adapterTypesConfig[selectedType?.adapter_type]?.label }}</span>
                            <ChevronRight size="10" />
                            <span>Подключение</span>
                        </div>
                        <div class="grid grid-cols-1 items-center gap-4">
                            <div class="flex flex-col">
                                <label class="form-label required" for="channelName">Название канала</label>
                                <InputText placeholder="Название канала" id="channelName" fluid required maxlength="255" v-model="channel.channel_name" />
                            </div>
                            <div v-for="field in selectedType?.settings_schema.fields || []" :key="field.name" class="flex flex-col">
                                <label class="form-label"
                                       :class="{'required': field.required || false}">
                                    {{ field.label }}
                                </label>
                                <InputText
                                    v-model="channel.credentials[field.name]"
                                    fluid
                                    :required="field.required || false"
                                    :placeholder="field.label"
                                />
                            </div>
                        </div>
                        <div class="flex justify-between">
                            <Button outlined @click="activateCallback('2')">
                                <ChevronLeft size="14" /> Назад
                            </Button>
                            <Button @click="activateCallback('4')" :disabled="!channel.channel_name">
                                Далее <ChevronRight size="14" />
                            </Button>
                        </div>
                    </div>
                </StepPanel>
                <StepPanel value="4" as-child v-slot="{activateCallback}">
                    <div class="flex flex-col gap-6">
                        <div class="flex items-center gap-1 text-sm text-muted-color">
                            <span class="flex items-center gap-1">
                                <Router size="14" />
                                <span class="font-medium">{{ adapterNamesConfig[selectedAdapter?.adapter_name]?.label }}</span>
                            </span>
                            <ChevronRight size="10" />
                            <span class="font-medium">{{ adapterTypesConfig[selectedType?.adapter_type]?.label }}</span>
                            <ChevronRight size="10" />
                            <span class="font-medium">Подключение</span>
                            <ChevronRight size="10" />
                            <span>Настройки</span>
                        </div>
                        <div class="grid grid-cols-1 items-center gap-4">
                            <div class="flex flex-col">
                                <label class="form-label" for="channelWelcomeMessage">Приветственное сообщение</label>
                                <Textarea
                                    placeholder="Приветственное сообщение"
                                    id="channelWelcomeMessage"
                                    maxlength="255"
                                    auto-resize fluid rows="3"
                                    v-model="channel.settings.welcome_message"
                                />
                            </div>
                        </div>
                        <div class="flex justify-between">
                            <Button outlined @click="activateCallback('3')">
                                <ChevronLeft size="14" /> Назад
                            </Button>
                            <Button @click="handleCreateChannel">
                                Создать канал
                            </Button>
                        </div>
                    </div>
                </StepPanel>
            </StepPanels>
        </Stepper>
    </div>
</template>
