<template>
    <div>
        <advert v-for="(advert, index) in items" v-bind:key="advert.id" v-bind:data="advert" @deleted="remove(index)"></advert>
        <paginator :dataSet="dataSet" @changed="fetch"></paginator>
    </div>
</template>

<script>

    import Advert from './Advert.vue';
    import collection from '../mixins/collection.js';

    export default {
        components: { Advert },

        mixins: [collection],

        data() {
            return {
                dataSet: false,
                city: this.citySlug
            }
        },

        created() {
            this.fetch();
        },

        methods: {
            fetch(page) {
                axios.get(this.url(page))
                    .then(this.refresh);
            },

            url(page) {
                if(!page) {
                    let query = location.search.match(/page=(\d+)/);

                    page = query ? query[1] : 1;
                }
                return location.pathname + '/ajax/adverts?page=' + page
            },

            refresh({data}) {
                this.dataSet = data;
                this.items = data.data;

                window.scrollTo(0, 0);
            }
        }
    }
</script>

