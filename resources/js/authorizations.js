let user = window.App.user;

let authorizations = {
    notAnOwner(advert) {
        return (user) ? advert.user_id !== user.id : true;
    },

    hasVerifiedEmail() {
        return !! (user) ? window.App.user.email_verified_at : false;
    },

    signedIn() {
        return window.App.signedIn;
    }
};

module.exports = authorizations;