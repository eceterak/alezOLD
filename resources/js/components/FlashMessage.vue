<template>
    <div class="alert alert-flash alert-dismissible fade show" role="alert" :class="'alert-' + level" v-show="show">
    <p class="mb-0" v-text="body"></p>
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
    </div>
</template>

<script>
    export default {
        props: [
            'message'
        ],

        data() {
            return {
                show: false,
                level: 'success',
                body: this.message
            }
        },

        created() {
            if(this.message) {
                this.flash();
            }

            window.events.$on('flash', data => {
                this.flash(data);
            });
        },

        methods: {
            flash(data) {
                if(data) {
                    this.body = data.message;
                    this.level = data.level;
                }
                
                this.show = true;

                this.hide();
            },

            hide() {
                setTimeout(() => {
                    this.show = false;
                }, 10000);
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
