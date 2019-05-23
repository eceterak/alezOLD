<template>
    <button :class="classes" @click="subscribe">Obserwuj</button>
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
                return ['btn', this.isActive ? 'btn-reverse' : 'btn-default'];
            }
        },

        methods: {

            subscribe() {
                axios[(this.isActive ? 'delete' : 'post')](location.pathname + '/obserwuj');

                this.isActive = !this.isActive;

                flash('Miasto obserwowane.');
            }
        }
    }
</script>

