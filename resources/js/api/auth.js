import api from "./axios.js";

export const csrf = () => api.get('/sanctum/csrf-cookie');
export const login = data => api.post('/api/login', data);
export const logout = () => api.post('/api/logout');
export const me = () => api.get('/api/me');
