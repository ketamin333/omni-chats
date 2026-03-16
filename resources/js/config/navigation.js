import {Folders, ListChecks, House, UsersRound} from "lucide-vue-next";

const groups = [
    {
        label: 'Основное',
        items: [
            { to: { name: 'dashboard' }, label: 'Дашборд', icon: House },
            { to: { name: 'projects' }, label: 'Проекты', icon: Folders },
            { to: { name: 'tasks' }, label: 'Задачи', icon: ListChecks },
        ]
    },
    {
        label: 'Настройки',
        items: [
            { to: { name: 'users' }, label: 'Команда', icon: UsersRound },
        ]
    }
];

export default groups;
