import {ClockFading, CircleAlert, Check} from "lucide-vue-next";

export const messageStatus = {
    pending: { icon: ClockFading },
    sent: { icon: Check },
    failed: { icon: CircleAlert },
    received: { icon: Check }
};
