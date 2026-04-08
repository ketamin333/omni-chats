import echo from '../echo.js';

export function useChannelsChannel(channels, total) {
    const channel = 'channels';

    const subscribe = () => {
        echo.private(channel)
            .listen('ChannelCreated', channel => {
                channels.value.unshift(channel);
                total.value++;
            });
    };

    const unsubscribe = () => echo.leave(channel);

    return { subscribe, unsubscribe };
}
