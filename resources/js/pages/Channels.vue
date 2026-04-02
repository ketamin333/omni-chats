<script setup>
    import {Button, Dialog, Stepper, Step, StepList, StepPanel, StepPanels, Divider} from "primevue";
    import {MessageCirclePlus} from 'lucide-vue-next';
    import {ref} from "vue";

    const visible = ref(true);
</script>

<template>
    <Dialog v-model:visible="visible" modal class="w-[45rem]" :show-header="false">
        <template #default>
            <Stepper value="1" linear class="pt-6">
                <StepList>
                    <Step value="1" asChild v-slot="{active}">
                        <button class="rounded-full p-2 text-muted-color">
                            <MessageCirclePlus />
                        </button>
                    </Step>
                </StepList>
                <StepPanels>
                    <StepPanel v-slot="{ activateCallback }" value="1">
<!--                        <div class="grid grid-cols-4 gap-3">-->
<!--                            <div class="p-4 rounded-xl cursor-pointer bg-sky-200 transition shadow-sm">-->
<!--                                <div class="flex flex-col gap-2 items-center">-->
<!--                                    <img width="32" height="32"-->
<!--                                        src="https://upload.wikimedia.org/wikipedia/commons/thumb/8/82/Telegram_logo.svg/960px-Telegram_logo.svg.png?_=20220101141644">-->
<!--                                    <span class="font-bold text-sm text-sky-700">Telegram</span>-->
<!--                                </div>-->
<!--                            </div>-->
<!--                        </div>-->
                    </StepPanel>
                    <StepPanel v-slot="{ activateCallback }" value="2">

                    </StepPanel>
                    <StepPanel v-slot="{ activateCallback }" value="3">

                    </StepPanel>
                </StepPanels>
            </Stepper>
        </template>
    </Dialog>
</template>
