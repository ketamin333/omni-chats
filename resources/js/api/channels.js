import api from "./axios.js";

export const getChannels = (page = 1) =>
    api.get('/api/channels', { params: { page } });
export const createChannel = data => api.post('/api/channels', data);
