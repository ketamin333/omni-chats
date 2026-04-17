export interface UserTimestamps {
    created_at: number;
    updated_at?: number;
    last_login_at: number | null;
    deleted_at?: number | null;
}

export interface UserList {
    user_id: number;
    username: string;
    email: string;
    avatar_url: string | null;
    phone: string | null;
    timestamps: UserTimestamps;
}

export interface User extends UserList {
    company_id: number;
    permissions: string[];
}

export interface CreateUserData {
    username: string;
    email: string;
    phone?: string;
    password: string;
    password_confirmation: string;
    permissions?: string[];
}

export interface UpdateUserData {
    username?: string;
    phone?: string;
    permissions?: string[];
}

export interface ChangePasswordUserData {
    password: string;
    password_confirmation: string;
}

export interface LoginUserData {
    email: string;
    password: string;
    remember_me: boolean;
}
