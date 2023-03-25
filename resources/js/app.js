/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

import VueRouter from 'vue-router'
import Paginate from 'vuejs-paginate'

Vue.use(VueRouter)

Vue.component('paginate', Paginate)

//vue progressbar
import VueProgressBar from 'vue-progressbar'
const options = {
    color: '#bffaf3',
    failedColor: 'red',
    thickness: '5px',
    transition: {
        speed: '0.2s',
        opacity: '0.6s',
        termination: 300
    },
    autoRevert: true,
    location: 'top',
    inverse: false
}

Vue.use(VueProgressBar, options)
Vue.prototype.$baseUrl = 'http://127.0.0.1:8000/'

// Sweet alert
import Swal from 'sweetalert2'
window.Swal = Swal

const Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
    didOpen: (toast) => {
        toast.addEventListener('mouseenter', Swal.stopTimer)
        toast.addEventListener('mouseleave', Swal.resumeTimer)
    }
})
window.Toast = Toast
    // Sweet alert end


//import user class
import User from './Helpers/User'
window.User = User
Vue.prototype.$user = User


//import Notification Class
import Notification from './Helpers/Notification'
window.Notification = Notification


//Custom event
window.Fire = new Vue

//All vue router
import { routes } from './routes'

const router = new VueRouter({
    routes,
    mode: 'history',
})


const app = new Vue({
    el: '#app',
    router
});