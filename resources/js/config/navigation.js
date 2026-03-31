import {ListChecks, House, UsersRound, MessageCircle, Rss} from "lucide-vue-next";

const groups = [
    {
        label: 'Основное',
        items: [
            { to: { name: 'dashboard' }, label: 'Дашборд', icon: House },
            { to: { name: 'chats' }, label: 'Чаты', icon: MessageCircle },
            { to: { name: 'tasks' }, label: 'Задачи', icon: ListChecks },
        ]
    },
    {
        label: 'Настройки',
        items: [
            { to: { name: 'channels' }, label: 'Каналы', icon: Rss },
            { to: { name: 'users' }, label: 'Пользователи', icon: UsersRound },
        ]
    }
];

export default groups;
