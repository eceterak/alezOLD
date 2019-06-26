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

// Authorize will be available on every vue components.
window.Vue.prototype.authorize = function(...params) {
    
    if(typeof params[0] === 'string') {
        return authorizations[params[0]](params[1]);
    }

    return params[0](window.App.user);
}

// Regeister new global method flash.
window.flash = function(message, level = 'success') {

    window.events.$emit('flash', {message, level});

};

// Components
Vue.component('image-upload-form', require('./components/ImageUploadForm.vue').default);
Vue.component('adverts', require('./components/Adverts.vue').default);
Vue.component('favourite', require('./components/Favourite.vue').default);
Vue.component('phone-number', require('./components/PhoneNumber.vue').default);
Vue.component('subscribe-button', require('./components/SubscribeButton.vue').default);
Vue.component('google-map', require('./components/GoogleMap.vue').default);
Vue.component('flash-message', require('./components/FlashMessage.vue').default);
Vue.component('avatar-form', require('./components/AvatarForm.vue').default);
Vue.component('user-notifications', require('./components/UserNotifications.vue').default);

// Initialize a Vue.
const app = new Vue({
    el: '#app'
});

/** JS */

try {
    window.Popper = require('popper.js').default;
    window.$ = window.jQuery = require('jquery');

    // jQuery UI
    require('jquery-ui/ui/widgets/autocomplete');
    require('jquery-ui/ui/widgets/button');
    //require('jquery-ui/ui/widgets/tooltip');
    require('jquery-ui/ui/widgets/datepicker');
    
    // Require after jQuery UI
    require('./combobox');
    require('./mBox');
    require('./poppa.js');
    require('bootstrap');
} catch (e) {}
