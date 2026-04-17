import api from "./axios";
import {Adapter} from "@/types/adapter";
import {ApiResponse} from "@/types/common";

export const getAdapters = (): Promise<ApiResponse<Adapter[]>> => api.get('/api/adapters');
