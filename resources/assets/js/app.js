import Vue from 'vue';
import axios from 'axios';
import moment from 'moment';

// Moment
Object.defineProperty(Vue.prototype, '$moment', { value: moment });
window._ = require('lodash');

// Axios
axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

let token = document.head.querySelector('meta[name="csrf-token"]');

if (token) {
    axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
} else {
    console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
}

Object.defineProperty(Vue.prototype, '$axios', { value: axios });

// Vue Components
Vue.component('radar-map', require('./components/Map.vue').default);

const app = new Vue({
    el: '#app'
});
