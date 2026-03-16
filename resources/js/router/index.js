import { createRouter, createWebHistory } from 'vue-router';

const routes = [
    {
        path: '/dashboard',
        name: 'dashboard',
        // component: import('../pages/Projects.vue'),
        component: '',
        children: [],
    },
    {
        path: '/projects',
        name: 'projects',
        component: '',
        children: [],
    },
    {
        path: '/tasks',
        name: 'tasks',
        component: '',
        children: [],
    },
    {
        path: '/users',
        name: 'users',
        component: '',
        children: []
    },
    { path: '/:pathMatch(.*)*', redirect: '/' }
];

const router = createRouter({ history: createWebHistory(), routes });

export default router;
