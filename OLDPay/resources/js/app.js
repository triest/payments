require('./bootstrap');
import Vue from 'vue'
window.Vue = require('vue');
import Vuex from 'vuex';

Vue.use(Vuex);


import App from './App.vue';
import VueAxios from 'vue-axios';
import VueRouter from 'vue-router';
import axios from 'axios';
import { routes } from './routes';


/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */



Vue.use(VueRouter);
Vue.use(VueAxios, axios);
Vue.use(Vuex);
window.axios = require('axios');

import {store} from './store/index';

const router = new VueRouter({
    base: '/app',
    mode: 'history',
    routes: routes
});

const DEFAULT_TITLE = 'Some Default Title';

router.afterEach((to, from) => {
    // Use next tick to handle router history correctly
    // see: https://github.com/vuejs/vue-router/issues/914#issuecomment-384477609
    Vue.nextTick(() => {
        document.title = to.meta.title || DEFAULT_TITLE;
    });
});

const app = new Vue({
    el: '#app',
    store: store,
    router: router,
    render: h => h(App),
});
