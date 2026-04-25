import { ListChecks, House, UsersRound, MessageCircle, Layers } from "lucide-vue-next";
import type { Component } from "vue";
import type { RouteLocationRaw } from "vue-router";

interface NavigationItem {
    to: RouteLocationRaw;
    label: string;
    icon: Component;
}

interface NavigationGroup {
    label: string;
    items: NavigationItem[];
}

const groups: NavigationGroup[] = [
    {
        label: 'Основное',
        items: [
            { to: { name: 'dashboard' }, label: 'Дашборд', icon: House },
            { to: { name: 'chats' }, label: 'Чаты', icon: MessageCircle },
        ]
    },
    {
        label: 'Настройки',
        items: [
            { to: { name: 'channels' }, label: 'Каналы', icon: Layers },
            { to: { name: 'users' }, label: 'Пользователи', icon: UsersRound },
        ]
    }
];

export default groups;
