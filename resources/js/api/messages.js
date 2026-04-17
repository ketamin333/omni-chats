import api from "./axios.js";

export const getMessages = (conversationId, cursor = null) =>
    api.get(`/api/conversations/${conversationId}/messages`, { params: { cursor } });
export const sendMessage = (conversationId, data) =>
    api.post(`/api/conversations/${conversationId}/messages`, data);
