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
                            @change="onFileChange($event.target.name, $event.target.files)"
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
    </div>
</template>

<script>
    export default {
        data() {
            return {
                maxSize: 2048,
                images: []
            }
        },

        computed: {
            canUpdate() {
                this.authorize(user => user.id === this.user.id);
            }
        },

        methods: {
            launchFilePicker() {
                this.$refs.file.click();
            },
            onFileChange(inputName, file) {
                const maxSize = this.maxSize;

                if(file.length > 0) {
                    for(var i = 0; i < file.length; i++) {
                        if(file[i].type.match('image.*')) {

                            let size = file[i].size / maxSize / maxSize;

                            if(size < 1) {                 
                                this.imageUpload(file[i])
                            }
                        }
                    }
                }
            },
            imageUpload(file) {

                var form = new FormData();
                form.append('files', file);

                $.ajax({
                    url: '/ajax/images/upload',
                    method: 'POST',
                    dataType: 'json',
                    processData: false,
                    contentType: false,
                    context: this,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: form,
                    success: function(data) {
                        this.images.push({
                            file: file,
                            url: data.url,
                            id: data.id
                        });
                    }
                });
            }
        }
    }
</script>
