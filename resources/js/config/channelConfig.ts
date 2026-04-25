import { Loader, WifiHigh, Check, CirclePause, Infinity, GitMergeConflict,
    GlobeX, Ban, CirclePlay, RefreshCcw } from "lucide-vue-next";
import type { Component } from "vue";

interface ChannelStatusConfig {
    label: string;
    severity: string;
    icon: Component;
    handlers?: string[];
}

interface ChannelHandlerConfig {
    label: string;
    icon: Component;
    handler: string;
}

export const channelStatus: Record<string, ChannelStatusConfig> = {
    pending: { label: 'Ожидание', severity: 'info', icon: Loader },
    connecting: { label: 'Соединение', severity: 'info', icon: WifiHigh },
    active: { label: 'Активен', severity: 'success', icon: Check, handlers: ['stop'] },
    paused: { label: 'На паузе', severity: 'warn', icon: CirclePause, handlers: ['start'] },
    rate_limited: { label: 'Спам', severity: 'warn', icon: Infinity },
    invalid_credentials: { label: 'Неверные данные', severity: 'danger', icon: GitMergeConflict, handlers: ['reconnect'] },
    disconnected: { label: 'Отключен', severity: 'danger', icon: GlobeX, handlers: ['reconnect'] },
    banned: { label: 'Заблокирован', severity: 'danger', icon: Ban },
};

export const channelHandler: Record<string, ChannelHandlerConfig> = {
    stop: { label: 'На паузу', icon: CirclePause, handler: 'handleStopChannel' },
    start: { label: 'Запустить', icon: CirclePlay, handler: 'handleStartChannel' },
    reconnect: { label: 'Переподключить', icon: RefreshCcw, handler: 'reconnectChannel' },
};
