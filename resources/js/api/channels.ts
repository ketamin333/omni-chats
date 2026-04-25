import api from "./axios.js";
import {PaginatedResponse} from "@/types/pagination";
import {Channel, ChannelStatus, CreateChannelData} from "@/types/channel";
import {ApiResponse} from "@/types/common";

export const getChannels = (page: number = 1): Promise<ApiResponse<PaginatedResponse<Channel>>> =>
    api.get('/api/channels', { params: { page } });
export const createChannel = (data: CreateChannelData): Promise<ApiResponse<Channel>> => api.post('/api/channels', data);
export const updateStatusChannel = (channelId: number, status: ChannelStatus): Promise<ApiResponse<Channel>> => api.patch(`/api/channels/${channelId}/status`, { status });
export const deleteChannel = (channelId: number): Promise<void> => api.delete(`/api/channels/${channelId}`);
