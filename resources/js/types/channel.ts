import {AdapterList} from "@/types/adapter";

export interface ChannelTimestamps {
    created_at: number;
    updated_at: number;
}

export type ChannelStatus = 'pending' | 'active' | 'paused' | 'rate_limited' | 'invalid_credentials' | 'disconnected' | 'banned';

export interface Channel {
    channel_id: number;
    channel_name: string;
    adapter: AdapterList;
    status: ChannelStatus;
    settings: object;
    timestamps: ChannelTimestamps
}

export interface CreateChannelData {
    adapter_id: number;
    channel_name: string;
    settings?: Record<string, string | null> | null;
    credentials?: Record<string, string | null> | null;
}
