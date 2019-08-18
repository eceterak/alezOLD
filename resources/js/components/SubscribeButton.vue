<template>
    <span>
        <button class="accountWarning" :class="classes" @click="subscribe">Obserwuj</button>
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
                return ['btn', 'btn-sm', this.isActive ? 'btn-primary' : 'btn-outline-primary'];
            },

            info() {
                return ! this.isActive ? 'Dodaj do obserwowanych i otrzymuj notyfikacje o nowych pokojach na wynajem' : 'Obserwujesz to miasto';
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

