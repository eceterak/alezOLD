<template>
    <div class="row">
        <div class="col-xl-11 mx-auto">
            <div class="bg-white rounded-lg py-2">
                <form :action="this.endpoint" method="get" name="search_master_form" autocomplete="off" id="search_master_form">
                    <div class="row align-items-center">
                        <div class="col-8 col-lg-5 border-separator">
                            <div class="input-group input-group-lg">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
                                </div>
                                <multiselect 
                                    v-model="city.selected" 
                                    :options="city.options"                
                                    :showLabels="false" 
                                    :searchable="true"
                                    :loading="city.isLoading"
                                    :showNoResults="false"
                                    :showNoOptions="false"
                                    :customLabel="cityLabel"
                                    openDirection="below" 
                                    placeholder="Wpisz miasto..."
                                    label="name"
                                    track-by="name"
                                    @search-change="findCity"
                                    class="form-control form-control-lg border-rounded-lg">
                                    <span class="d-none" slot="caret"></span>
                                </multiselect>
                                <input type="hidden" name="city_id" v-model="selectedCityId">
                            </div>
                        </div>
                        <div class="col-lg-3 d-none d-lg-flex input-group input-group-lg border-separator">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
                            </div>
                            <multiselect 
                                v-model="roomSize.selected" 
                                :options="roomSize.options"                
                                :showLabels="false" 
                                :searchable="false"
                                openDirection="below" 
                                placeholder="Wielkość pokoju"
                                label="name"
                                track-by="name"
                                class="form-control form-control-lg">
                            </multiselect>
                            <input type="hidden" name="room_size" v-model="selectedRoomSize">
                        </div>
                        <div class="col-lg-2 d-none d-lg-flex input-group input-group-lg">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
                            </div>
                            <multiselect 
                                v-model="radius.selected" 
                                :options="radius.options" 
                                :showLabels="false" 
                                :searchable="false"
                                openDirection="below" 
                                placeholder="+ 0 km"
                                label="name"
                                track-by="name"
                                class="form-control form-control-lg">
                            </multiselect>
                            <input type="hidden" name="radius" v-model="selectedRadius">
                        </div>
                        <div class="col-4 col-lg-2">
                            <button class="btn btn-primary font-weight-bold float-right btn-block mr-2">Szukaj</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
    import Multiselect from 'vue-multiselect';
    import debounce from 'debounce';

    export default {
        components: {Multiselect, debounce},

        props: [
            'endpoint'
        ],

        data() {
            return {
                city: {
                    selected: null,
                    options: [],
                    isLoading: false
                },
                roomSize: {
                    selected: null,
                    options: [
                        {name: 'Wielkość pokoju', value: ''}, 
                        {name: 'jednoosobowy', value: 'single'}, 
                        {name: 'dwuosobowy', value: 'double'}, 
                        {name: 'trzyosobowy lub większy', value: 'triple'}
                    ]
                },
                radius: {
                    selected: null,
                    options: [
                        {name: '+ 0 km', value: ''}, 
                        {name: '+ 5 km', value: '5'}, 
                        {name: '+ 10 km', value: '10'}, 
                        {name: '+ 15 km', value: '15'}, 
                        {name: '+ 25 km', value: '25'}, 
                        {name: '+ 50 km', value: '50'}
                    ]
                }
            }
        },

        computed: {
            selectedRoomSize() {
                return this.roomSize.selected ? this.roomSize.selected.value : '';
            },
            selectedRadius() {
                return this.radius.selected ? this.radius.selected.value : '';
            },
            selectedCityId() {
                return this.city.selected ? this.city.selected.id : '';
            }
        },

        methods: {
            findCity: debounce(function(query) {
                if(query.length > 2) {
                    this.city.isLoading = true;

                    axios.get('/ajax/cities', {
                        params: {
                            search: query
                        }
                    }).then(response => {
                        if(response.data) {
                            this.city.options = response.data;
                            this.city.isLoading = false;
                        }
                    });
                }
                else {
                    this.city.options = [];
                }
            }, 500),
            cityLabel({name, state, county}) {
                return `${name}, ${county}, ${state}`;
            }
        }
    }
</script>

<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>

<style>

    .multiselect {
        box-sizing: border-box;
        color: #929292;
    }

    .multiselect__tags {
        border: transparent;
        font-size: inherit;
        padding: 0 30px 0 0;
        min-height: 40px;
    }

    .multiselect__option--highlight {
        background-color: #02807e;
    }

    .multiselect__placeholder {
        color: #929292;
        cursor: pointer;
        padding: 0;
        margin: 0;
    }

    .multiselect__single {
        text-overflow: ellipsis;
        white-space: nowrap;
        overflow: hidden;
        cursor: pointer;
        padding: 0;
    }

    .multiselect__input, .multiselect__single {
        line-height: inherit;
        margin: 0;
        padding: 0;
    }

    .multiselect__content-wrapper {
        box-shadow: 0 1rem 3rem rgba(0, 0, 0, 0.175) !important;
    }

</style>

