<script>
    import Adverts from '../components/Adverts.vue';

    export default {
        props: [ 'initialAdvertsCount' ],

        components: { Adverts },

        computed: {
            advertsCount() {
                if(this.initialAdvertsCount > 0) {
                    return 'Znaleziono ' + this.initialAdvertsCount;
                }
                return 'Brak ogłoszen';
            }
        }
    }
</script>
