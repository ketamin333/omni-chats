import echo from '@/echo';
import { useAuthStore } from "@/stores/useAuthStore";
import { watch, Ref } from "vue";
import { Channel } from "@/types/channel";

export function useChannelsChannel(channels: Ref<Channel[]>, total: Ref<number>) {
    const auth = useAuthStore();

    const subscribe = () => {
        watch(() => auth.user, user => {
            if (!user) return;

            echo.private(`channels.${user.company_id}`)
                .listen('ChannelCreated', (channel: Channel) => {
                    channels.value.unshift(channel);
                    total.value++;
                })
                .listen('ChannelUpdated', (channel: Channel) => {
                    const index = channels.value.findIndex(c => c.channel_id === channel.channel_id);
                    if (index !== -1) channels.value[index] = channel;
                })
                .listen('ChannelDeleted', (channel: Channel) => {
                    channels.value = channels.value.filter(c => c.channel_id !== channel.channel_id);
                    total.value--;
                });
        }, { immediate: true });
    };

    const unsubscribe = () => {
        if (auth.user) echo.leave(`channels.${auth.user.company_id}`);
    };

    return { subscribe, unsubscribe };
}
