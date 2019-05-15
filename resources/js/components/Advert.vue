<template>
    <article class="card lg:flex mb-4">
        <div class="flex lg:static lg:w-1/8 items-center justify-center mb-0 lg:mb-0 sm:mb-2">
            <img src="/storage/notfound.png">
        </div>
        <div class="lg:static lg:w-7/8 lg:pl-2">
            <header clas="flex jutify-between">
                <h3 class="font-normal text-lg mb-2"><a :href="url" v-text="title"></a></h3>
                <div v-if="signedIn">
                    <favourite :advert="data"></favourite>
                </div>
                <div v-if="isAdmin">
                    <button class="btn btn-primary" @click="destroy">Usuń</button>
                </div>
            </header>
            <section class="pb-2 px-4">
                <p class="text-grey-darker">{{ description }}</p>
            </section>
        </div>
    </article>
</template>

<script>
    import Favourite from './Favourite.vue';

    export default {
        props: [ 'data' ],

        components: { Favourite },

        data() {
            return {
                description: this.data.description.substring(0, 100),
                title: this.data.title,
                slug: this.data.slug,
                citySlug: this.data.city.slug,
                editing: false
            }
        },

        computed: {
            signedIn() {
                return window.App.signedIn
            },

            isAdmin() {
                return this.authorize(user => this.data.user_id == user.id);
            },

            url() {
                return '/pokoje/' + this.citySlug + '/' + this.slug;
            }
        },

        methods: {
            destroy() {
                axios.delete('/pokoje/' + this.slug);

                this.$emit('deleted', this.data.id);

                flash('Ogłoszenie zostało usunięte');
            }
        }
    }
</script>