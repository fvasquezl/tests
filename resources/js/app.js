require('./bootstrap');

window.Vue = require('vue');

import router from '../routes/router'

const app = new Vue({
    el: '#app',
    router
});
