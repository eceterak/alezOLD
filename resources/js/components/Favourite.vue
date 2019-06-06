<template>
    <button class="btn btn-link p-0 accountWarning" @click="addFavourite" v-if="authorize('notAnOwner', this.advert)">
        <small class="mr-2" v-text="info"></small>
        <i :class="classes"></i>
    </button>
</template>

<script>
    export default {
        props: [
            'advert'
        ],

        data() {
            return {
                isFavourited: this.advert.isFavourited
            }
        },

        computed: {
            classes() {
                return ['fa-heart', this.isFavourited ? 'fas' : 'far'];
            },

            endpoint() {
                return '/pokoje/' + this.advert.city.slug + '/' + this.advert.slug + '/ulubione'
            },

            info() {
                return ! this.isFavourited ? 'Dodaj do ulubionych' : 'W Twoich ulubionych';
            }
        },

        methods: {   
            addFavourite() {
                if(this.authorize('hasVerifiedEmail')) return this.isFavourited ? this.destroy() : this.create();
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

