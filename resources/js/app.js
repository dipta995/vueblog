

require('./bootstrap');

//defult view imported
window.Vue = require('vue').default;
//sweet alert2
import Swal from 'sweetalert2'
window.Swal = Swal;
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
  
  window.Toast = Toast;

//Toastr message 
import toastr from 'toastr'
window.toastr = toastr;


// Moment for date formation
import {datefilter} from './filter/datefilter.js';



//v form 
//import { Form, HasError, AlertError } from 'vform'
import Form from 'vform'
window.Form = Form;

//vuex use

import Vuex from 'vuex'

Vue.use(Vuex)
import storeData from "./store/storeData";
const store = new Vuex.Store(
  storeData
  );


//router import
import VueRouter from 'vue-router'
Vue.use(VueRouter)
//es6 style
//import {routes} from './routes/routes';
import {routes} from './routes/routes.js';
const router = new VueRouter({
    routes
    //mode:'history',
  });


//Vue.component('example-component', require('./components/ExampleComponent.vue').default);
//mixin
import './helpers/mixin';
 
const app = new Vue({
    el: '#content',
    router,
    store
});
