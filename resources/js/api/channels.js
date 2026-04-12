import api from "./axios.js";

export const getChannels = (page = 1) =>
    api.get('/api/channels', { params: { page } });
export const createChannel = data => api.post('/api/channels', data);
export const updateStatusChannel = (channelId, status) => api.patch(`/api/channels/${channelId}/status`, { status });
export const deleteChannel = channelId => api.delete(`/api/channels/${channelId}`);
