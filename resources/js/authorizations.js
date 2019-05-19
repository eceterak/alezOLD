let user = window.App.user;

let authorizations = {
    notAnOwner(advert) {
        return advert.user_id !== user.id;
    },

    signedIn() {
        return window.App.signedIn;
    }
};

module.exports = authorizations;