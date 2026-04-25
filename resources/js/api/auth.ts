import api from "./axios";
import {LoginUserData, User} from "@/types/user";
import {ApiResponse} from "@/types/common";

export const csrf = (): Promise<void> => api.get('/sanctum/csrf-cookie');
export const login = (data: LoginUserData): Promise<void> => api.post('/api/login', data);
export const logout = (): Promise<void> => api.post('/api/logout');
export const me = (): Promise<ApiResponse<User>> => api.get('/api/me');
