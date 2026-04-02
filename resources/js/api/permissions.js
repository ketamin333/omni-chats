import api from "./axios.js";

export const getPermissions = () => api.get('/api/permissions');
