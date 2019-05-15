<template>
    <button class="btn btn-link" @click="addFavourite">
        <i :class="classes"></i>
    </button>
</template>

<script>
    export default {
        props: [
            'advert'
        ],

        computed: {
            classes() {
                return ['fa-heart', this.isFavourited ? 'fas' : 'far'];
            },
            endpoint() {
                return '/pokoje/' + this.advert.slug + '/ulubione'
            }
        },

        data() {
            return {
                isFavourited: this.advert.isFavourited
            }
        },

        methods: {   
            addFavourite() {
                return this.isFavourited ? this.destroy() : this.create();
            },

            create() {
                axios.post(this.endpoint);

                this.isFavourited = true;
                flash('Dodano do ulubionych');
            },

            destroy() {
                axios.delete(this.endpoint);

                this.isFavourited = false;
                flash('Usunięto z ulubionych');
            },
        }
    }
</script>

