require('./bootstrap');
import Test from './components/Test.vue';

window.Vue = require('vue');

Vue.component('test', require('./components/Test.vue').default);
//Vue.component('test', require(Test).default);

console.log('ebinwewwww');

const app = new Vue({
    el: '#app',
});