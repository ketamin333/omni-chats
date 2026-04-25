import api from "./axios";
import {Message} from "@/types/message";
import {CursorPaginatedResponse} from "@/types/pagination";
import {ApiResponse} from "@/types/common";

export const getMessages = (conversationId: string, cursor: string|null = null): Promise<ApiResponse<CursorPaginatedResponse<Message>>> =>
    api.get(`/api/conversations/${conversationId}/messages`, { params: { cursor } });
export const sendMessage = (conversationId: string, data: { text: string|null }): Promise<ApiResponse<Message>> =>
    api.post(`/api/conversations/${conversationId}/messages`, data);
