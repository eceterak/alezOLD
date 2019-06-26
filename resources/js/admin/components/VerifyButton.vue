<template>
    <button class="btn btn-sm d-inline-block mr-2" :class="warning" @click="verify"><i :class="classes"></i></button>
</template>

<script>
    export default {
        props: ['verified'],

        data() {
            return {
                isVerified: this.verified
            }
        },

        computed: {
            classes() {
                return ['fas', this.isVerified ? 'fa-check text-red' : 'fa-exclamation text-success'];
            },
            warning() {
                return ['fas', this.isVerified ? 'btn-success' : 'btn-warning'];
            }
        },

        methods: {
            verify() {
                if(!this.isVerified) {
                    axios.post(location.pathname + '/weryfikuj');
    
                    this.isVerified = true;
                }
            }
        }
    }
</script>

