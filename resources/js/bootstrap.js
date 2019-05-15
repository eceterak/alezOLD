/** Axios */

window.axios = require('axios');

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

let token = document.head.querySelector('meta[name="csrf-token"]');

if(token) {
    window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
} 
else {
    console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
}

/** Vue */

window.Vue = require('vue');

// Make instance of a user available globally.
window.Vue.prototype.authorize = function(handler) {

    let user = window.App.user;

    return user ? handler(user) : false;
}

window.events = new Vue();

// Regeister new global method flash.
window.flash = function(message) {

    window.events.$emit('flash', message);

};

// Load components.
Vue.component('image-upload', require('./components/ImageUpload.vue').default);

Vue.component('paginator', require('./components/Paginator.vue').default);

Vue.component('favourite', require('./components/Favourite.vue').default);

Vue.component('user-notifications', require('./components/UserNotifications.vue').default);

Vue.component('subscribe-button', require('./components/SubscribeButton.vue').default);

Vue.component('flash-message', require('./components/FlashMessage.vue').default);

Vue.component('city-view', require('./pages/City.vue').default);

// Initialize a Vue.
const app = new Vue({
    el: '#app'
});

/** JS */

try {
    window.Popper = require('popper.js').default;
    window.$ = window.jQuery = require('jquery');
    require('jquery-ui/ui/widgets/autocomplete');
    require('jquery-ui/ui/widgets/button');
    require('jquery-ui/ui/widgets/tooltip');
    require('jquery-ui/ui/widgets/datepicker');
} catch (e) {}
