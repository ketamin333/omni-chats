import api from "./axios.js";

export const getUsers = (page = 1) => api.get('/api/users', { params: { page } });
export const getUser = userId => api.get(`/api/users/${userId}`);
export const createUser = data => api.post('/api/users', data, {
    headers: {'Content-Type': 'multipart/form-data'}
});
export const updateUser = (userId, data) => api.patch(`/api/users/${userId}`, data);
export const updateUserAvatar = (userId, avatar) => api.post(`/api/users/${userId}/avatar`, { avatar }, {
    headers: {'Content-Type': 'multipart/form-data'}
});
export const deleteUser = userId => api.delete(`/api/users/${userId}`);
