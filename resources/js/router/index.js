import { createRouter, createWebHistory } from 'vue-router';
import { useAuthStore } from '../stores/auth';
import GuestLayout from '../layouts/GuestLayout.vue';
import AuthLayout from '../layouts/AppLayout.vue';

const routes = [
    {
        path: '/login',
        component: GuestLayout,
        meta: { guest: true },
        children: [
            { path: '', component: () => import('../pages/Login.vue'), meta: { title: 'Вход' } },
        ]
    },
    {
        path: '/',
        component: AuthLayout,
        meta: { auth: true },
        children: [
            { path: 'projects', component: () => import('../pages/Projects.vue'), meta: { title: 'Проекты' } },
        ]
    },
    { path: '/:pathMatch(.*)*', redirect: '/' }
];

const router = createRouter({ history: createWebHistory(), routes });

router.beforeEach(async (to, from, next) => {
    const auth = useAuthStore();

    document.title = to.meta.title ? `${to.meta.title} — Проекты` : 'Проекты';

    console.log(to);

    next();

    // if (!auth.initialized) {
    //     await auth.fetchUser();
    // }
    //
    // if (to.meta.auth && !auth.isAuthenticated) {
    //     return next('/login');
    // }
    //
    // if (to.meta.guest && auth.isAuthenticated) {
    //     return next('/');
    // }
    //
    // next();
});

export default router;
