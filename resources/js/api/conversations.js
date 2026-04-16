import api from "./axios.js";

export const getConversations = (page = 1) =>
    api.get('/api/conversations', { params: { page } });
