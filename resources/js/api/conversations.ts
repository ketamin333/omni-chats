import api from "./axios";
import {Conversation} from "@/types/conversation";
import {PaginatedResponse} from "@/types/pagination";
import {ApiResponse} from "@/types/common";

export const getConversations = (page: number = 1): Promise<ApiResponse<PaginatedResponse<Conversation>>> =>
    api.get('/api/conversations', { params: { page } });
export const getConversation = (conversationId: string): Promise<ApiResponse<Conversation>> => api.get(`/api/conversations/${conversationId}`);
