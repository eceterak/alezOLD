<template>
    <nav class="paginator" v-if="shouldPaginate">
        <ul>
            <li v-show="prevUrl">
                <a href="#" rel="prev" @click.prevent="page--">&laquo;</a>
            </li>
            <li v-show="nextUrl">
                <a href="#" rel="next" @click.prevent="page++">&raquo;</a>
            </li>
        </ul>
    </nav>
</template>

<script>
    export default {
        props: ['dataSet'],
        
        data() {
            return {
                page: 1,
                prevUrl: false,
                nextUrl: false
            }
        },

        watch: {
            dataSet() {
                this.page = this.dataSet.current_page;
                this.prevUrl = this.dataSet.prev_page_url;
                this.nextUrl = this.dataSet.next_page_url;
            },

            page() {
                this.broadcast().updateUrl();
            }
        },

        computed: {
            shouldPaginate() {
                return !! this.prevUrl || !! this.nextUrl;
            }
        },

        methods: {
            broadcast() {
                return this.$emit('changed', this.page);
            },

            updateUrl() {
                history.pushState(null, null, '?page=' + this.page);
            }
        }
    }
</script>
