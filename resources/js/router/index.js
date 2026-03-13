import { createRouter, createWebHistory } from 'vue-router';
import { useAuthStore } from '../stores/auth';
import GuestLayout from '../layouts/GuestLayout.vue';
import AuthLayout from '../layouts/AppLayout.vue';

const routes = [
    {
        path: '/login',
        component: GuestLayout,
        children: [
            { path: '', component: () => import('../pages/Login.vue'), meta: { title: 'Вход' } },
        ]
    },
    {
        path: '/',
        component: AuthLayout,
        meta: { requiresAuth: true },
        children: [
            // { path: 'dashboard', component: () => import('../pages/dashboard/Dashboard.vue') },
        ]
    },
    { path: '/:pathMatch(.*)*', redirect: '/' }
];

const router = createRouter({ history: createWebHistory(), routes: routes });

router.beforeEach(async (to, from, next) => {
    const auth = useAuthStore();

    document.title = to.meta.title ? `${to.meta.title} — Проекты` : 'Проекты';

    if (auth.token && !auth.user) {
        await auth.fetchUser();
    }

    if (to.meta.requiresAuth && !auth.isAuth) {
        next('/login');
    } else if (to.path === '/' && auth.isAuth) {
        next('/');
    } else {
        next();
    }
})

export default router;
