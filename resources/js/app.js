
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');
Vue.prototype.$csrf_token = $('meta[name="csrf-token"]').attr('content');

Vue.filter('toCurrency2', function (value) {
    if (typeof value !== "number") {
        value = value.toString();
    }
    var formatter = new Intl.NumberFormat('pt-BR', {
        style: 'currency',
        currency: 'BRL',
        minimumFractionDigits: 2
    });
    return formatter.format(value);
});

Vue.filter('toCurrency3', function (value) {
    if (typeof value !== "number") {
        value = value.toString();
    }
    var formatter = new Intl.NumberFormat('pt-BR', {
        style: 'currency',
        currency: 'BRL',
        minimumFractionDigits: 3
    });
    return formatter.format(value);
});

Vue.filter('toDecimal2', function (value) {
    if (typeof value !== "number") {
        value = value.toString();
    }
    var formatter = new Intl.NumberFormat('pt-BR', {
        minimumFractionDigits: 2
    });
    return formatter.format(value);
});

Vue.filter('toDecimal3', function (value) {
    if (typeof value !== "number") {
        value = value.toString();
    }
    var formatter = new Intl.NumberFormat('pt-BR', {
        minimumFractionDigits: 3
    });
    return formatter.format(value);
});

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

/* Vue.component('example', require('./components/Example.vue'));

const app = new Vue({
    el: '#app'
}); */
