export interface ContactTimestamps {
    created_at: number;
    updated_at: number;
}

export interface Contact {
    contact_id: number;
    username: string;
    avatar_url?: string;
    phone?: string;
    email?: string;
    timestamps: ContactTimestamps;
}
