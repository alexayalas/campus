
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

Vue.component( 'navbar', require('./components/main/NavBar/Navbar.vue'));
Vue.component( 'topbar', require('./components/main/Topbar/Topbar.vue'));
Vue.component( 'footervue', require('./components/main/Footer/FooterVue.vue'));
Vue.component('breadcrumb', require('./components/main/Breadcrumb/Breadcrumb.vue'));

import router from './router';
import store from './store';

const app = new Vue({
    router,
    store,    
    el: '#app',
    data:''
});
