<template>
    <div class="mb-4">
        <p class="mb-2 small">Pierwsze zdjęcie jest miniaturką. Możesz przeciągać zdjęcia aby zmienić ich kolejność.</p>
        <div class="p-3 rounded border-grey border">
            <draggable v-model="images" draggable=".photo" class="row mx-n2" @end="orderChanged">
                <div class="col-2 px-2 photo" v-for="(image, index) in images" :key="image.id">
                    <div class="d-flex position-relative justify-content-center align-items-center h-10 border rounded">
                        <p class="position-absolute p-2" style="top: 0; right: 0;">
                            <a href="#" @click.prevent="destroy(image, index)"><i class="fas fa-times"></i></a>
                        </p>
                        <img :src="'https://alez.s3.eu-central-1.amazonaws.com/' + image.url" class="img-fluid">
                    </div>
                </div>
                <div class="col-2 px-2" slot="footer" v-if="images.length < 6">
                    <div class="d-flex justify-content-center align-items-center h-10 border rounded">
                        <input type="file"
                            ref="file"
                            @change="onFileChange"
                            name="image[]"
                            multiple 
                            class="inputfile" 
                            id="image">
                        <label @click="launchFilePicker()"><i class="fas fa-plus-circle fa-3x"></i></label>
                    </div>
                </div>
            </draggable>
        </div>
        <p class="mt-2 text-xs text-grey-darkest">Możesz dodać 6 zdjęć.</p>
        <p v-if="error" v-text="error" class="text-red"></p>
        <input type="hidden" name="photos" v-if="ids" :value="ids">
    </div>
</template>

<script>
    import drragable from 'vuedraggable';

    export default {
        props: [
            'temp', 
            'advert'
        ],

        components: { drragable },

        data() {
            return {
                maxSize: 4096,
                images: [],
                ids: false,
                error: false
            }
        },

        created() {
            if(this.advert) this.images = this.advert.photos
        },

        computed: {
            endpoint() {
                return this.advert ? '/api/ogloszenia/zdjecia/' + this.advert.slug : '/api/ogloszenia/zdjecia';
            },
            method() {
                return this.advert ? 'patch' : 'post';
            }
        },

        watch: {
            images() {
                this.ids = this.images.map(img => img.id).join(',');

                var photo = this.images[0];

                // axios.patch('/api/ogloszenia/zdjecia/' + photo.id)
                //     .then(photo.featured = true)
                //     .catch(error => flash(error.response.data.errors.photo[0], 'danger'));
            }
        },

        methods: {
            launchFilePicker() {
                this.$refs.file.click();
            },
            onFileChange(e) {
                const maxSize = this.maxSize;

                let files = e.target.files;

                if(files.length > 0) {
                    for(var i = 0; i < files.length; i++) {
                        if(files[i].type.match('image.*')) {

                            let size = files[i].size / maxSize / maxSize;

                            if(size < 1 && this.images.length < 6) {                 
                                this.persist(files[i])
                            }
                        }
                    }
                }
            },
            persist(photo) {
                var data = new FormData();
                data.append('photo', photo);
                data.append('_method', this.method);

                axios.post(this.endpoint, data)
                    .then(response =>this.images.push(response.data))
                    .catch(error => flash(error.response.data.errors.photo[0], 'danger'));
            },
            destroy(image, index) {
                this.images.splice(index, 1);

                axios.delete('/api/ogloszenia/zdjecia/' + image.id)
                    .then()
                    .catch(error => flash(error.response.data.errors.photo[0], 'danger'));
            },
            orderChanged(e) {
                axios.post('/api/zdjecia/' + this.advert.slug, {
                    photos: this.ids,
                    _method: 'patch'
                });
            }
        }
    }
</script>
