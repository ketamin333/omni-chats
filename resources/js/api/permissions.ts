import api from "./axios";
import {Permission} from "@/types/permission";
import {ApiResponse} from "@/types/common";

export const getPermissions = (): Promise<ApiResponse<Permission[]>> => api.get('/api/permissions');
