import { createRouter, createWebHistory } from 'vue-router';

const routes = [
    {
        path: '/dashboard',
        name: 'dashboard',
        meta: { title: 'Дашборд' },
        // component: import('../pages/Projects.vue'),
    },
    {
        path: '/projects',
        name: 'projects',
        meta: { title: 'Проекты' },
        component: '',
    },
    {
        path: '/tasks',
        name: 'tasks',
        meta: { title: 'Задачи' },
        component: '',
    },
    {
        path: '/users',
        name: 'users',
        meta: { title: 'Пользователи' },
        component: import('../pages/Users.vue'),
    },
    { path: '/:pathMatch(.*)*', redirect: 'dashboard' }
];

const router = createRouter({ history: createWebHistory(), routes });

router.afterEach(to => document.title = to?.meta?.title || 'Проекты');

export default router;
