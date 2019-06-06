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
window.events = new Vue();

let authorizations = require('./authorizations');

// Make instance of a user available globally.
window.Vue.prototype.authorize = function(...params) {
    
    if(typeof params[0] === 'string') {
        return authorizations[params[0]](params[1]);
    }

    return params[0](window.App.user);
}

Vue.mixin({
    methods: {
        cccd: function() {
            console.log('hi');
        }
    }
});


// Load components.
Vue.component('image-upload-form', require('./components/ImageUploadForm.vue').default);
Vue.component('paginator', require('./components/Paginator.vue').default);
Vue.component('favourite', require('./components/Favourite.vue').default);
Vue.component('user-notifications', require('./components/UserNotifications.vue').default);
Vue.component('subscribe-button', require('./components/SubscribeButton.vue').default);
Vue.component('flash-message', require('./components/FlashMessage.vue').default);
Vue.component('avatar-form', require('./components/AvatarForm.vue').default);
Vue.component('city-view', require('./pages/City.vue').default);


// Regeister new global method flash.
window.flash = function(message, level = 'success') {

    window.events.$emit('flash', {message, level});

};

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
    //require('jquery-ui/ui/widgets/tooltip');
    require('jquery-ui/ui/widgets/datepicker');

    require('bootstrap');
} catch (e) {}
