<template>
    <div class="mb-4">
        <p class="mb-2">Pierwsze zdjęcie jest miniaturką. Możesz przeciągać zdjęcia aby zmienić ich kolejność.</p>
        <div class="image-upload position-relative p-3 rounded">
            <div class="spinner" v-show="isUploading"><i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i></div>
            <draggable v-model="images" draggable=".photo" class="row mx-n2 photos-list" @end="orderChanged" :class="isUploading ? 'disabled-content' : ''">
                <div class="col-6 col-lg-2 px-2 photo photo-item" v-for="(image, index) in images" :key="image.id">
                    <div class="d-flex position-relative justify-content-center align-items-center h-12 border rounded image-container">
                        <p class="position-absolute p-2" style="top: 0; right: 0;">
                            <a href="#" @click.prevent="destroy(image, index)"><i class="fas fa-times"></i></a>
                        </p>
                        <img :src="'https://alez.s3.eu-central-1.amazonaws.com/' + image.url" class="img-fluid">
                    </div>
                </div>
                <div class="col-6 col-lg-2 px-2 photo-item" slot="footer" v-if="images.length < maxImages">
                    <div class="d-flex justify-content-center align-items-center h-12 border rounded image-container" @click="launchFilePicker()">
                        <input type="file"
                            ref="file"
                            @change="onFileChange"
                            name="image[]"
                            multiple 
                            class="inputfile" 
                            id="image">
                        <label><i class="fas fa-plus-circle fa-3x"></i></label>
                    </div>
                </div>
            </draggable>
        </div>
        <p class="mt-2 text-xs text-grey-darkest" v-text="'Możesz dodać  ' + maxImages + ' zdjęć.'"></p>
        <p v-if="error" v-text="error" class="text-red"></p>
        <input type="hidden" name="photos" v-if="ids" :value="ids">
    </div>
</template>

<script>
    import drragable from 'vuedraggable';
    import uuidv1 from 'uuid/v1';

    export default {
        props: [
            'advert'
        ],

        components: { drragable },

        data() {
            return {
                maxSize: 4096,
                images: [],
                ids: false,
                error: false,
                maxImages: 7,
                isUploading: false
            }
        },

        created() {
            if(this.advert) this.images = this.advert.photos
        },

        computed: {
            endpoint() {
                return this.advert ? '/api/ogloszenia/zdjecia/' + this.advert.slug : '/api/ogloszenia/zdjecia/' + this.temp;
            },
            method() {
                return this.advert ? 'patch' : 'post';
            },
            temp() {
                return uuidv1();
            }
        },

        watch: {
            images() {
                this.ids = this.images.map(img => img.id).join(',');
            }
        },

        methods: {
            launchFilePicker() {
                this.$refs.file.click();
            },
            async onFileChange(e) {
                let files = e.target.files;

                if(files.length > 0) {

                    this.isUploading = true;

                    for(var i = 0; i < files.length; i++) {
                        if(files[i].type.match('image.*')) {
                            try {
                                this.checkSize(files[i]);
                                this.checkCount();

                                await this.persist(files[i]);
                            } 
                            catch(error) {
                                flash(error, 'danger');
                            }
                        }
                    }

                    this.isUploading = false;
                }
            },
            checkSize(file) {
                const maxSize = this.maxSize;

                let size = file.size / 1024 / maxSize;

                if(size > 1) throw "Plik jest zbyt duży, maksymalny rozmiar to " + maxSize / 1024  + " mb";
            },
            checkCount() {
                if(this.images.length >= 7) throw "Możesz dodać maksymalnie " + this.maxImages + " zdjęć. Maksymalny rozmiar zdjęcia to " + this.maxSize / 1024 + " mb.";
            },
            async persist(photo) {
                var data = new FormData();
                data.append('photo', photo);
                data.append('_method', this.method);

                await axios.post(this.endpoint, data)
                    .then(response => this.images.push(response.data))
                    .catch(error => flash(error.response.data.message, 'danger'));
            },
            destroy(image, index) {
                this.images.splice(index, 1);

                axios.delete('/api/ogloszenia/zdjecia/' + image.id + '/' + this.temp)
                    .catch(error => flash(error.response.data.message, 'danger'));
            },
            orderChanged() {
                axios.post('/api/zdjecia/' + this.advert.slug, {
                    photos: this.ids,
                    _method: 'patch'
                });
            }
        }
    }
</script>

<style >

</style>

<style lang="scss" scoped>

    .disabled-content {
        pointer-events: none;
        opacity: 0.4;
    }
    
    .spinner {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        z-index: 999;
    }

    .image-upload {
        background-color: #f7f7f9;
        
        .image-container {
            border: 1px solid #d6dde4 !important;
            color: #d6dde4;
        }
    }

    /* .photos-list .photo-item:first-child div {
        border: 1px solid teal!important;
    }

    .photos-list .photo-item:last-child {
        margin-top: 1rem;
    } */

</style>

