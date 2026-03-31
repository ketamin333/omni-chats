export default [
    {
        path: '/users',
        name: 'users',
        meta: { title: 'Пользователи' },
        component: () => import('../../pages/Users.vue'),
    },
];
