<template>
    <span>
        <button class="accountWarning btn btn-link pr-0" @click="subscribe"><span class="d-none d-lg-inline mr-2" v-text="info"></span><i class="fa-lg" :class="classes"></i></button>
    </span>
</template>

<script>
    export default {
        props: ['active'],

        data() {
            return {
                isActive: this.active
            }
        },

        computed: {
            classes() {
                return this.isActive ? ['fas', 'fa-star'] : ['far', 'fa-star'];
            },

            info() {
                return ! this.isActive ? 'Dodaj do obserwowanych' : 'Obserwowane';
            }
        },

        methods: {
            subscribe() {
                if(this.authorize('hasVerifiedEmail')) return this.isActive ? this.destroy() : this.create();

            },
            create() {
                axios.post(location.pathname + '/obserwuj');

                this.isActive = !this.isActive;

                flash('Miasto dodane do obserwowanych');                
            },
            destroy() {
                axios.delete(location.pathname + '/obserwuj');

                this.isActive = !this.isActive;

                flash('Miasto usunięte z obserwowanych');
            }
        }
    }
</script>

