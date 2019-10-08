<template>
    <div @click="showPhoneNumber">
        <i class="fas fa-phone fa-flip-horizontal mr-3"></i><span class="mb-0 phone-number" v-text="phone"></span><small v-if="!visible && !placeholder" class="ml-2">pokaż</small>
    </div>
</template>

<script>
    export default {
        props: [
            'advert', 'placeholder'
        ],

        data() {
            return {
                phone: this.placeholder ? this.placeholder : this.advert.PhoneTranslated,
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