
window._ = require('lodash');

/**
 * We'll load jQuery and the Bootstrap jQuery plugin which provides support
 * for JavaScript based Bootstrap features such as modals and tabs. This
 * code may be modified to fit the specific needs of your application.
 */
window.Vue = require('vue');

import VueRouter from 'vue-router'
import VModal from 'vue-js-modal'
import VuejsDialog from 'vuejs-dialog';
import './interceptors'
import VueGoodTable from 'vue-good-table';
import ToggleButton from 'vue-js-toggle-button';
import underscore from 'vue-underscore';



/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

window.axios = require('axios');

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

// import Echo from 'laravel-echo'

// window.Pusher = require('pusher-js');

// window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: 'your-pusher-key'
// });

Vue.use(VueRouter)
Vue.use(VueGoodTable)
Vue.use(VModal)
Vue.use(VuejsDialog);
Vue.use(ToggleButton);
Vue.use(underscore);

