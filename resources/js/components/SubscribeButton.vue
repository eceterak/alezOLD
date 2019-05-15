<template>
    <button :class="classes" @click="subscribe">Obserwuj</button>
</template>

<script>
    export default {
        props: ['active'],

        computed: {
            classes() {
                return ['btn', this.active ? 'btn-reverse' : 'btn-default'];
            }
        },

        methods: {

            subscribe() {
                axios[(this.active ? 'delete' : 'post')](location.pathname + '/obserwuj');

                this.active = !this.active;

                flash('Miasto obserwowane.');
            }
        }
    }
</script>

