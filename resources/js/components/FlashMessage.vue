<template>
    <div class="alert-flash bg-red p-3 text-white rounded" v-show="show">{{ body }}</div>
</template>

<script>
    export default {
        props: [
            'message'
        ],
        data() {
            return {
                show: false,
                body: this.message
            }
        },
        created() {
            if(this.message) {
                this.flash(this.message);
            }

            window.events.$on('flash', message => {
                this.flash(message);
            });
        },
        methods: {
            flash(message) {
                this.body = message;
                this.show = true;

                this.hide();
            },

            hide() {
                setTimeout(() => {
                    this.show = false;
                }, 3000);
            }
        }
    }
</script>

<style>
    .alert-flash {
        position: fixed;
        bottom: 50px;
        right: 50px;
    }
</style>
