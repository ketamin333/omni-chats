import {UserList} from "@/types/user";

export interface AttachmentTimestamps {
    created_at: number;
    updated_at: number;
}

export interface MessageTimestamps {
    created_at: number;
    updated_at: number;
}

export interface Attachment {
    attachment_id: number;
    original_name: string;
    url: string;
    mime_type: string;
    size: number;
    timestamps: AttachmentTimestamps;
}

export interface Message {
    message_id: number;
    conversation_id: string;
    direction: 'incoming' | 'outgoing';
    status: 'pending' | 'sent' | 'failed';
    text: string | null;
    sender?: UserList;
    attachments?: Attachment[];
    timestamps: MessageTimestamps;
}
