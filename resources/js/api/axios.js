import axios from 'axios';

const api = axios.create({
    withCredentials: true,
    withXSRFToken: true,
    baseURL: '/',
    headers: {
        common: { Accept : 'application/json' },
    },
});

api.interceptors.response.use(
    r => r.data,
    e => {
        if (e.response?.status === 401 && !e.config.url.includes('/login')) {
            window.location.href = '/login';

            return Promise.reject(e);
        }

        return Promise.reject(e?.response?.data || e);
    }
);

export default api;
