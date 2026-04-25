import {Channel} from "@/types/channel";
import {Message} from "@/types/message";
import {Contact} from "@/types/contact";

export interface ConversationTimestamps {
    created_at: number;
    updated_at: number;
}

export interface Conversation {
    conversation_id: string;
    status: 'open' | 'pending' | 'closed';
    contact: Contact;
    channel: Channel;
    last_message?: Message;
    timestamps: ConversationTimestamps;
}
