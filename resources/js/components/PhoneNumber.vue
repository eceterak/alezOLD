<template>
    <button class="btn btn-light accountWarning font-weight-bold rounded-sm btn-block" @click="showPhoneNumber">
        <i class="fas fa-phone fa-flip-horizontal mr-3"></i><span class="mr-2 mb-0 phone-number" v-text="phone"></span><small v-if="!visible">pokaż</small>
    </button>
</template>

<script>
    export default {
        props: [
            'advert'
        ],

        data() {
            return {
                phone: this.advert.PhoneTranslated,
                visible: false
            }
        },

        methods: {   
            showPhoneNumber() {
                axios.get('/api/ogloszenia/' + this.advert.slug + '/phone')
                    .then(response => {
                        if(response.data.phone) {
                            this.phone = response.data.phone;
                            this.visible = true;
                        }
                        else flash('Coś poszło nie tak... Spróbuj ponownie później', 'danger');
                    })
                    .catch(error => flash('Coś poszło nie tak... Spróbuj ponownie później', 'danger'));
            }
        }
    }
</script>

<style lang="scss" scoped>

.phone-number {
    font-size: 1.1rem;
}

</style>