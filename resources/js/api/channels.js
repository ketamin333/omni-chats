import api from "./axios.js";

export const createChannel = data => api.post('/api/channels', data);
