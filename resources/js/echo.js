import Echo from "laravel-echo";
import Pusher from "pusher-js";
import axiosInstance from './api/axios.js';

window.Pusher = Pusher;

const echo = new Echo({
    broadcaster: 'reverb',
    key: import.meta.env.VITE_REVERB_APP_KEY,
    wsHost: import.meta.env.VITE_REVERB_HOST,
    wsPort: import.meta.env.VITE_REVERB_PORT,
    wssPort: import.meta.env.VITE_REVERB_PORT,
    forceTLS: import.meta.env.VITE_REVERB_SCHEME === 'https',
    enabledTransports: ['ws', 'wss'],
    authorizer: channel => ({
        authorize: (socketId, callback) => {
            axiosInstance
                .post('/broadcasting/auth', {
                    socket_id: socketId,
                    channel_name: channel.name
                })
                .then(r => callback(null, r))
                .catch(e => callback(e));
        }
    }),
});

export default echo;
