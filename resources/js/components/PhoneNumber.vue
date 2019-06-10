<template>
    <button class="btn btn-secondary accountWarning" @click="showPhoneNumber">
        <small class="mr-2" v-text="phone"></small><i class="fas fa-phone"></i>
    </button>
</template>

<script>
    export default {
        props: [
            'advert'
        ],

        data() {
            return {
                phone: this.advert.PhoneTranslated
            }
        },

        methods: {   
            showPhoneNumber() {
                axios.get('/api/ogloszenia/' + this.advert.slug + '/phone')
                    .then(response => {
                        if(response.data.phone) this.phone = response.data.phone
                        else flash('Coś poszło nie tak... Spróbuj później', 'danger');
                    })
                    .catch(error => flash('Coś poszło nie tak... Spróbuj później', 'danger'));
            }
        }
    }
</script>

