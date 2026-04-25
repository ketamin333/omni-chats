import echo from "../echo.js";

export function useConversationChannel(conversationId, onMessage) {
    const channel = `conversations.${conversationId}`;

    const subscribe = () => {
        echo.private(channel).listen('MessageCreated', onMessage);
    };

    const unsubscribe = () => echo.leave(channel);

    return { subscribe, unsubscribe };
}
