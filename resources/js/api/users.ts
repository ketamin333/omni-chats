import api from "./axios.js";
import {PaginatedResponse} from "@/types/pagination";
import {ChangePasswordUserData, CreateUserData, UpdateUserData, User, UserList} from "@/types/user";
import {ApiResponse} from "@/types/common";

export const getUsers = (page: number = 1, sortField: string|null = null, sortOrder: string|null = null, search: string|null = null): Promise<ApiResponse<PaginatedResponse<UserList>>> =>
    api.get('/api/users', { params: { page, sort_field: sortField, sort_order: sortOrder, search } });
export const getUser = (userId: number): Promise<ApiResponse<User>> => api.get(`/api/users/${userId}`);
export const createUser = (data: CreateUserData): Promise<ApiResponse<User>> => api.post('/api/users', data, {
    headers: {'Content-Type': 'multipart/form-data'}
});
export const updateUser = (userId: number, data: UpdateUserData): Promise<ApiResponse<User>> => api.patch(`/api/users/${userId}`, data);
export const updateUserAvatar = (userId: number, avatar: File): Promise<ApiResponse<User>> => api.post(`/api/users/${userId}/avatar`, { avatar }, {
    headers: {'Content-Type': 'multipart/form-data'}
});
export const changeUserPassword = (userId: number, data: ChangePasswordUserData): Promise<void> => api.put(`/api/users/${userId}/password`, data);
export const deleteUser = (userId: number): Promise<void> => api.delete(`/api/users/${userId}`);
