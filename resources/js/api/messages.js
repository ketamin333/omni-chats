import api from "./axios.js";

export const getMessages = (conversationId, cursor = null) =>
    api.get(`/api/conversations/${conversationId}/messages`, { params: { cursor } });
