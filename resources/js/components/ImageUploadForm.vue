<template>
    <div class="mb-4">
        <p class="mb-2 text-xs text-grey-darkest">Pierwsze zdjęcie jest miniaturką. Możesz przeciągać zdjęcia aby zmienić ich kolejność.</p>
        <div class="w-full p-4 rounded border-grey border">
            <draggable v-model="images" draggable=".photo" class="flex flex-row flex-wrap items-center -mx-2">
                <div class="w-1/6 px-2 photo" v-for="(image, index) in images" :key="image.id">
                    <div class="flex relative items-center justify-center h-32 border-grey border rounded text-grey">
                        <p class="absolute p-2" style="top: 0; right: 0;">
                            <a href="#" @click.prevent="destroy(image, index)"><i class="fas fa-times"></i></a>
                        </p>
                        <img :src="image.url">
                    </div>
                </div>
                <div class="w-1/6 px-2" slot="footer">
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
        props: ['temp'],

        components: { drragable },

        data() {
            return {
                maxSize: 2048,
                images: [],
                ids: false,
                error: false
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

                axios.post('/api/ogloszenia/zdjecia', data)
                    .then(response => this.images.push(response.data))
                    .catch(error => flash(error.response.data.errors.photo[0]));
            },
            destroy(image, index) {
                this.images.splice(index, 1);

                axios.delete('/api/ogloszenia/zdjecia/' + image.id)
                    .then()
                    .catch(error => flash(error.response.data.errors.photo[0]));
            }
        }
    }
</script>
