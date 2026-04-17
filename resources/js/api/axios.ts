import axios, { AxiosResponse, InternalAxiosRequestConfig } from 'axios';

const api = axios.create({
    withCredentials: true,
    withXSRFToken: true,
    baseURL: '/',
    headers: {
        common: { Accept : 'application/json' },
    },
});

api.interceptors.response.use(
    (r: AxiosResponse) => r.data,
    (e: { response?: AxiosResponse; config: InternalAxiosRequestConfig }) => {
        if (e.response?.status === 401 && !e.config.url?.includes('/login')) {
            window.location.href = '/login';

            return Promise.reject(e);
        }

        return Promise.reject((e.response as AxiosResponse<{message: string; errors?: Record<string, string[]>}>)?.data || e);
    }
);

export default api;
