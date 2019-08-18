<template>
    <button class="btn btn-link p-0 accountWarning " @click="addFavourite" v-if="authorize('notAnOwner', this.advert)">
        <i :class="classes" class="fa-heart favourite-heart"></i>
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
                return this.isFavourited ? 'fas' : 'far';
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

<style>
    .favourite-heart {
        background-color: #f3f2f2;
        padding: .75rem;
        border-radius: 50%;
        color: #3b4249;
    }

    #breadcrumbs .favourite-heart {
        background-color: #FFF;
        padding: .75rem;
        font-size: 1.2rem;
    }
</style>
