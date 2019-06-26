<template>
    <div class="mb-4">
        <div class="position-relative p-3 rounded border-grey border">
            <div class="spinner" v-show="isUploading"><i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i></div>
            <draggable v-model="images" draggable=".photo" class="row mx-n2 photos-list" @end="orderChanged" :class="isUploading ? 'disabled-content' : ''">
                <div class="col-2 px-2 photo photo-item" v-for="(image, index) in images" :key="image.id">
                    <div class="d-flex position-relative justify-content-center align-items-center h-10 border rounded">
                        <span class="position-absolute photo-utilities d-flex justify-content-between mb-0 p-2">
                            <a href="#" @click.prevent="verify(image, index)" v-show="! image.verified"><i class="fas fa-check"></i></a>
                            <a href="#" @click.prevent="destroy(image, index)"><i class="fas fa-times"></i></a>
                        </span>
                        <img :src="'https://alez.s3.eu-central-1.amazonaws.com/' + image.url" class="img-fluid">
                    </div>
                </div>
                <div class="col-2 px-2 photo-item" slot="footer" v-if="images.length < maxImages">
                    <div class="d-flex justify-content-center align-items-center h-10 border rounded" @click="launchFilePicker()">
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
        <div class="d-flex justify-content-between mt-2 align-items-center">
            <p class="my-0 text-xs text-grey-darkest" v-text="'Możesz dodać  ' + maxImages + ' zdjęć.'"></p>
            <button class="btn btn-primary btn-sm" v-show="photosVerified" @click.prevent="bulkVerify" type="button">Weryfikuj wszystkie</button>
        </div>
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
                maxSize: 3072,
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
            },
            photosVerified() {
                return this.images.some(photo => photo.verified === false);
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

                let size = file.size / maxSize / maxSize;

                if(size > 1) throw "Plik jest zbyt duży, maksymalny rozmiar to " + maxSize / 1024  + " mb";
            },
            checkCount() {
                if(this.images.length >= 7) throw "Możesz dodać maksymalnie " + this.maxImages + " zdjęć";
            },
            async persist(photo) {
                var data = new FormData();
                data.append('photo', photo);
                data.append('_method', this.method);

                await axios.post(this.endpoint, data)
                    .then(response => this.images.push(response.data))
                    .catch(error => flash(error.response.data.message, 'danger'));
            },
            verify(image, index) {
                axios.patch('/api/zdjecia/' + image.id + '/weryfikuj') 
                    .then(response => {
                        flash(response.data.message)

                        image.verified = true;
                    })
                    .catch(error => flash(error.response.data.message, 'danger'));

            },
            bulkVerify() {
                axios.post('/api/zdjecia/' + this.advert.slug + '/weryfikuj')
                    .then(response => {
                        flash(response.data.message)
                        
                        this.images.map(photo => photo.verified = true);
                    })
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

<style>

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

    .photos-list .photo-item:first-child div {
        border: 1px solid teal!important;
    }

    .photo-utilities {
        top: 0px;
        left: 0px;
        width: 100%;
    }

</style>

