import echo from '../echo.js';

export function useChannelsChannel(channels, total) {
    const channel = 'channels';

    const subscribe = () => {
        echo.private(channel)
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
    };

    const unsubscribe = () => echo.leave(channel);

    return { subscribe, unsubscribe };
}
