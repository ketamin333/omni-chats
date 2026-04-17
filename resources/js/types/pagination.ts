export interface PaginatedResponse<T> {
    data: T[];
    meta: {
        total: number;
        per_page: number;
        current_page: number;
        last_page: number;
    };
}

export interface CursorPaginatedResponse<T> {
    data: T[];
    meta: {
        per_page: number;
        next_cursor: string | null;
        prev_cursor: string | null;
        has_more: boolean;
    };
}
