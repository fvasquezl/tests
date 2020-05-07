require('./bootstrap');

window.Vue = require('vue');


import Form from './Form'
window.Form = Form

import router from '../routes/router'

//Sweetalert
import Swal from 'sweetalert2'
window.Swal = Swal;

const Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000
});
window.Toast = Toast;

//ProgressBar
import VueProgressBar from 'vue-progressbar'

Vue.use(VueProgressBar, {
    color: 'rgb(143, 255, 199)',
    failedColor: 'red',
    height: '3px'
});


window.Fire = new Vue();

const app = new Vue({
    el: '#app',
    router
});
