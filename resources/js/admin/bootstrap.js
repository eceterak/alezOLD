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

let authorizations = require('../authorizations');

// Authorize will be available on every vue component.
window.Vue.prototype.authorize = function(...params) {
    
    if(typeof params[0] === 'string') {
        return authorizations[params[0]](params[1]);
    }

    return params[0](window.App.user);
}

// Register new global method flash.
window.flash = function(message, level = 'success') {

    window.events.$emit('flash', {message, level});

};

// Components
Vue.component('verify-button', require('./components/VerifyButton.vue').default);
Vue.component('image-upload-form', require('./components/ImageUploadForm.vue').default);
Vue.component('flash-message', require('../components/FlashMessage.vue').default);

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
    require('../combobox');
    require('../mBox');
    require('bootstrap');
} catch (e) {}
