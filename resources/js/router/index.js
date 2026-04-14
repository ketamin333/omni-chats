import { createRouter, createWebHistory } from 'vue-router';

const routes = [
    {
        path: '/dashboard',
        name: 'dashboard',
        meta: { title: 'Дашборд' },
    },
    {
        path: '/chats',
        name: 'chats',
        meta: { title: 'Чаты',  },
        component: () => import('../pages/Chats.vue'),
        children: [
            {
                path: ':id',
            }
        ]
    },
    {
        path: '/channels',
        name: 'channels',
        meta: { title: 'Каналы' },
        component: () => import('../pages/Channels.vue'),
    },
    {
        path: '/users',
        name: 'users',
        meta: { title: 'Пользователи' },
        component: () => import('../pages/Users.vue'),
    },

    { path: '/:pathMatch(.*)*', redirect: 'dashboard' }
];

const router = createRouter({ history: createWebHistory(), routes });

router.afterEach(to => document.title = to?.meta?.title || 'Проекты');

export default router;
