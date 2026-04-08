import api from "./axios.js";

export const getAdapters = () => api.get('/api/adapters');
