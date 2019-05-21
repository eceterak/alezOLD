<template>
    <div class="mb-4">
        <p class="mb-2 text-xs text-grey-darkest">Pierwsze zdjęcie jest miniaturką.</p>
        <div class="w-full p-4 rounded border-grey border">
            <div class="flex flex-row flex-wrap items-center -mx-2">
                <div class="w-1/6 px-2" v-for="image in images">
                    <div class="flex items-center justify-center h-32 border-grey border rounded text-grey">
                        <img :src="image.url">
                        <input type="hidden" name="img[]" v-model="image.id">
                    </div>
                </div>
                <div class="w-1/6 px-2">
                    <div class="flex items-center justify-center h-32 border-grey border rounded">
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
            </div>
        </div>
        <p class="mt-2 text-xs text-grey-darkest">Możesz dodać 6 zdjęć.</p>
        <input type="hidden" name="photos" v-if="ids" :value="ids">
    </div>
</template>

<script>
    import Cookies from 'js-cookie';

    export default {
        props: ['temp'],

        data() {
            return {
                maxSize: 2048,
                images: [],
                ids: false
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
            onFileChange(e) {
                const maxSize = this.maxSize;

                let files = e.target.files;

                if(files.length > 0) {
                    for(var i = 0; i < files.length; i++) {
                        if(files[i].type.match('image.*')) {

                            let size = files[i].size / maxSize / maxSize;

                            if(size < 1) {                 
                                this.persist(files[i])
                            }
                        }
                    }
                }
            },
            persist(photo) {
                var data = new FormData();
                data.append('photo', photo);

                axios.post('/api/ogloszenia/zdjecia/upload', data)
                    .then(response => this.images.push(response.data));
            }
        }
    }
</script>
