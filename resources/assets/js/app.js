
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

import './bootstrap';


// Vue
import Vue from 'vue';


// Vue plugins
import VueAnimateNumber from 'vue-animate-number';
Vue.use(VueAnimateNumber);

import vmodal from 'vue-js-modal'
Vue.use(vmodal);


// Vue components
Vue.component('network-overview', require('./components/NetworkOverview.vue'));
Vue.component('validators-overview', require('./components/ValidatorsOverview.vue'));

const app = new Vue({
    el: '#app'
});


// Lodash in Vue
Vue.prototype._ = _;

// Moment JS in Vue
Vue.prototype.moment = moment;