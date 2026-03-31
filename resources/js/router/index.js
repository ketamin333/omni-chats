import { createRouter, createWebHistory } from 'vue-router';
import userRoutes from './routes/users.js';

const routes = [
    {
        path: '/dashboard',
        name: 'dashboard',
        meta: { title: 'Дашборд' },
        // component: import('../pages/Projects.vue'),
    },
    {
        path: '/chats',
        name: 'chats',
        meta: { title: 'Чаты' },
        component: '',
    },
    {
        path: '/tasks',
        name: 'tasks',
        meta: { title: 'Задачи' },
        component: '',
    },
    {
        path: '/channels',
        name: 'channels',
        meta: { title: 'Каналы' },
        component: () => import('../pages/Channels.vue'),
    },
    ...userRoutes,

    { path: '/:pathMatch(.*)*', redirect: 'dashboard' }
];

const router = createRouter({ history: createWebHistory(), routes });

router.afterEach(to => document.title = to?.meta?.title || 'Проекты');

export default router;
