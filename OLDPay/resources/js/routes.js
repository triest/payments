import Pay from "./components/Pay";

import Vue from 'vue'
import Order from "./components/Order";

Vue.component('app', require('./App.vue').default);

export const routes = [
    {
        name: 'orders',
        path: '/',
        component: Order,
        meta: {title: 'Главная'}
    },
    {
        name: 'order',
        path: '/:id',
        component: Pay,
        meta: {title: 'Оплата'}
    },

];


