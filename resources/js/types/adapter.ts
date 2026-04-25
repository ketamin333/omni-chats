export interface AdapterList {
    adapter_id: number;
    adapter_name: string;
    adapter_type: string;
    slug: string;
}

export interface Adapter extends AdapterList{
    settings_schema: object;
    is_enabled: boolean;
}
