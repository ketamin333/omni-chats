import { ClockFading, CircleAlert, Check } from "lucide-vue-next";
import type { Component } from "vue";

interface MessageStatusConfig {
    icon: Component;
}

export const messageStatus: Record<string, MessageStatusConfig> = {
    pending: { icon: ClockFading },
    sent: { icon: Check },
    failed: { icon: CircleAlert },
    received: { icon: Check }
};
