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
    response => response,
    error => {
        if (error.response?.status === 401) {
            window.location.href = '/login';
        }

        return Promise.reject(error);
    }
)

export default api;
