import api from "./axios.js";

export const getUsers = (page = 1) => api.get('/api/users', { params: { page } });

