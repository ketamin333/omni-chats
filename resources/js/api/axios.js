import axios from 'axios';

const api = axios.create({
    withCredentials: true,
    withXSRFToken: true,
    baseURL: '/',
    headers: {
        common: { Accept : 'application/json' },
    },
});

export default api;
