<template>
    <div class="text-center">
        <input type="file"
            ref="file"
            @change="onChange"
            name="image"
            class="inputfile" 
            accept="image/*"
            id="image">
        <label @click="launchFilePicker" class="btn btn-secondary text-white"><i class="fas fa-upload fa-lg"></i><span class="ml-3" v-text="btnText"></span></label>
    </div>

</template>

<script>
    export default {
        props: ['btnText', 'maxSize'],
        methods: {
            launchFilePicker() {
                this.$refs.file.click();
            },
            onChange(e) {
                if(e.target.files.length) {
                    let file = e.target.files[0];

                    try {
                        this.checkSize(file);

                        this.persist(file);
                    } 
                    catch(error) {
                        flash(error, 'danger');
                    }
                    
                }
            },
            checkSize(file) {
                const maxSize = this.maxSize;

                let size = file.size / maxSize / maxSize;

                if(size > 1) throw "Plik jest zbyt duży, maksymalny rozmiar to " + maxSize + " kB";
            },
            persist(file) {
                let reader = new FileReader();

                reader.readAsDataURL(file);

                reader.onload = e => {
                    this.$emit('loaded', {
                        src: e.target.result,
                        file: file
                    })
                };
            }
        }    
    }
</script>

