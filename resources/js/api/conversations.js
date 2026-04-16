import api from "./axios.js";

export const getConversations = (page = 1) =>
    api.get('/api/conversations', { params: { page } });
export const getConversation = conversationId => api.get(`/api/conversations/${conversationId}`);
