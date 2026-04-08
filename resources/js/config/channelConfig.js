import {
    Loader, WifiHigh, Router, Check, LoaderCircle, CirclePause, Infinity, RefreshCcw, GitMergeConflict,
    CalendarX, GlobeX, Ban
} from "lucide-vue-next";

export const channelStatus = {
    // BASE STATES
    pending: { label: 'Ожидание', severity: 'info', icon: Loader },
    connecting: { label: 'Соединение', severity: 'info', icon: WifiHigh },
    authenticating: { label: 'Авторизация', severity: 'info', icon: Router },

    // ACTIVE STATES
    authenticated: { label: 'Авторизирован', severity: 'success', icon: LoaderCircle },
    active: { label: 'Активен', severity: 'success', icon: Check },

    // WORK STATES
    paused: { label: 'На паузе', severity: 'warn', icon: CirclePause },
    rate_limited: { label: 'Спам', severity: 'warn', icon: Infinity },
    reconnecting: { label: 'Перезапуск', severity: 'warn', icon: RefreshCcw },

    // ERRORS STATES
    invalid_credentials: { label: 'Неверные данные', severity: 'danger', icon: GitMergeConflict },
    expired: { label: 'Истек', severity: 'danger', icon: CalendarX },

    // CRIT STATES
    disconnected: { label: 'Отключен', severity: 'danger', icon: GlobeX },
    banned: { label: 'Заблокирован', severity: 'danger', icon: Ban },
};
