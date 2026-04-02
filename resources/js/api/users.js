import api from "./axios.js";

export const getUsers = (page = 1) => api.get('/api/users', { params: { page } });
export const createUser = data => api.post('/api/users', data, {
    headers: {'Content-Type': 'multipart/form-data'}
});
