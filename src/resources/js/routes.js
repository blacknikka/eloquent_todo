import VueRouter from 'vue-router';

import Top from './views/pages/top.vue';

const routes = [
    {path: '/', component: Top},
];

const router = new VueRouter({
    routes,
    linkActiveClass: 'active',
    mode: 'history',
});

export default router;
