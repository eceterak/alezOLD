<template>
    <button class="btn btn-light accountWarning font-weight-bold rounded-sm btn-block" @click="showPhoneNumber">
        <i class="fas fa-phone fa-flip-horizontal mr-2"></i><span class="mr-2 mb-0" v-text="phone"></span>pokaż
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

