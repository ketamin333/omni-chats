import echo from '../echo.js';

export function useUsersChannel(users, total) {
    const channel = 'users';

    const subscribe = () => {
        echo.private(channel)
            .listen('UserCreated', user => {
                users.value.unshift(user);
                total.value++;
            })
            .listen('UserUpdated', user => {
                const userIndex = users.value.findIndex(u => u.user_id === user.user_id);
                if (userIndex !== -1) {
                    users.value[userIndex] = user;
                }
            })
            .listen('UserDeleted', user => {
                users.value = users.value.filter(u => u.user_id !== user.user_id);
                total.value--;
            });
    };

    const unsubscribe = () => echo.leave(channel);

    return { subscribe, unsubscribe };
}
