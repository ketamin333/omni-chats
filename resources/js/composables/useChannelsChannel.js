import echo from '../echo.js';
import {useAuthStore} from "../stores/useAuthStore.js";
import {watch} from "vue";

export function useChannelsChannel(channels, total) {
    const auth = useAuthStore();

    const subscribe = () => {
        watch(() => auth.user, user => {
            if (!user) {
                return;
            }

            echo.private(`channels.${user.company_id}`)
                .listen('ChannelCreated', channel => {
                    channels.value.unshift(channel);
                    total.value++;
                })
                .listen('ChannelUpdated', channel => {
                    const channelIndex = channels.value.findIndex(c => c.channel_id === channel.channel_id);
                    if (channelIndex !== -1) {
                        channels.value[channelIndex] = channel;
                    }
                })
                .listen('ChannelDeleted', channel => {
                    channels.value = channels.value.filter(c => c.channel_id !== channel.channel_id);
                    total.value--;
                });
        }, { immediate: true });
    };

    const unsubscribe = () => {
        if (auth.user) {
            echo.leave(`channels.${auth.user.company_id}`);
        }
    };

    return { subscribe, unsubscribe };
}
