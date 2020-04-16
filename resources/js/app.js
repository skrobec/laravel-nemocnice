/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */


require('./bootstrap');

window.Vue = require('vue');

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('patients-form', require('./components/PatientsForm.vue').default);
Vue.component('drug-form', require('./components/DrugForm.vue').default);
Vue.component('section-form', require('./components/SectionForm.vue').default);
Vue.component('serving-form', require('./components/ServingForm.vue').default);
Vue.component('admin-form', require('./components/AdminForm.vue').default);
Vue.component('hospitalization-form', require('./components/HospitalizationForm.vue').default);
Vue.component('intervention-form', require('./components/InterventionForm.vue').default);
Vue.component('exam-form', require('./components/ExamForm.vue').default);



Vue.component('patient-detail', require('./components/details/PatientDetail.vue').default);
Vue.component('serving-detail', require('./components/details/ServingDetail.vue').default);
Vue.component('intervention-detail', require('./components/details/InterventionDetail.vue').default);
Vue.component('admin-detail', require('./components/details/AdminDetail.vue').default);
Vue.component('hospitalization-detail', require('./components/details/HospitalizationDetail.vue').default);
Vue.component('exam-detail', require('./components/details/ExamDetail.vue').default);
Vue.use(require('vue-moment'));


import Calendar from 'v-calendar/lib/components/calendar.umd';
import DatePicker from 'v-calendar/lib/components/date-picker.umd';

// Register components in your 'main.js'
Vue.component('calendar', Calendar);
Vue.component('date-picker', DatePicker);

//Vue.component('calendar', require('v-calendar/lib/components/calendar.umd'));
//Vue.component('date-picker', require('v-calendar/lib/components/date-picker.umd'));
  
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
});



