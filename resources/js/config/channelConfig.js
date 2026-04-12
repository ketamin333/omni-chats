import {Loader, WifiHigh, Router, Check, LoaderCircle, CircleStop, CirclePlay,
    CirclePause, Infinity, RefreshCcw, GitMergeConflict, CalendarX, GlobeX, Ban
} from "lucide-vue-next";

export const channelStatus = {
    // BASE STATES
    pending: { label: 'Ожидание', severity: 'info', icon: Loader },
    connecting: { label: 'Соединение', severity: 'info', icon: WifiHigh },

    // ACTIVE STATES
    active: { label: 'Активен', severity: 'success', icon: Check, handlers: ['stop'] },

    // WORK STATES
    paused: { label: 'На паузе', severity: 'warn', icon: CirclePause, handlers: ['start'] },
    rate_limited: { label: 'Спам', severity: 'warn', icon: Infinity },

    // CRIT STATES
    invalid_credentials: { label: 'Неверные данные', severity: 'danger', icon: GitMergeConflict, handlers: ['reconnect'] },
    disconnected: { label: 'Отключен', severity: 'danger', icon: GlobeX, handler: ['reconnect'] },
    banned: { label: 'Заблокирован', severity: 'danger', icon: Ban },
};

export const channelHandler = {
    stop: { label: 'На паузу', icon: CirclePause, handler: 'handleStopChannel' },
    start: { label: 'Запустить', icon: CirclePlay, handler: 'handleStartChannel' },
    reconnect: { label: 'Переподключить', icon: RefreshCcw, handler: 'reconnectChannel' },
};
