<template>
    <div class="text-center">
        <div class="d-flex position-relative justify-content-center align-items-center mb-4">
            <div class="spinner" v-show="isUploading"><i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i></div>
            <div class="position-absolute p-2" style="top: 0; right: 0;" v-if="!isDefaultAvatar">
                <a href="#" @click.prevent="destroy"><i class="fas fa-times"></i></a>
            </div>
            <img :src="avatar" class="img-fluid rounded-circle p-6 p-lg-4" :class="isUploading ? 'disabled-content' : ''">
        </div>
        <button class="btn btn-primary text-white font-weight-bold" id="avatar-pick"><i class="fas fa-upload fa-lg"></i><span class="ml-3" v-text="btnText"></span></button>
        <avatar-cropper 
            :labels="labels"
            trigger="#avatar-pick"
            :upload-handler="onFileChange">
        </avatar-cropper>
    </div>
</template>

<script>
    import AvatarCropper from "vue-avatar-cropper";

    import toBlob from "canvas-to-blob";

    export default {

        components: {AvatarCropper},

        props: ['user'],

        data() {
            return {
                avatar: this.user.avatar_path,
                maxSize: 400,
                isUploading: false,
                labels: {
                    submit: 'Zapisz',
                    cancel: 'Anuluj'
                }
            };
        },
        computed: {
            canUpdate() {
                return this.authorize(user => user.id === this.user.id)
            },
            isDefaultAvatar() {
                return this.avatar == '/storage/avatars/notfound.jpg';
            },
            btnText() {
                return this.isDefaultAvatar ? 'Dodaj avatar' : 'Zmień avatar';
            },
            endpoint() {
                return '/api/uzytkownicy/' + this.user.id + '/avatars';
            }
        },

        methods: {
            async onFileChange(e) {
                
                var blob = toBlob(e.getCroppedCanvas().toDataURL());

                try {
                    this.checkType(blob);
                    this.checkSize(blob);

                    await this.persist(blob);
                } 
                catch(error) {
                    flash(error, 'danger');
                }

                this.isUploading = false
            },
            checkType(file) {
                if(!file.type.match('image.*')) throw "Nieprawidłowy plik";
            },
            checkSize(file) {
                const maxSize = this.maxSize;

                let size = file.size / 1024 / maxSize;

                if(size > 1) throw "Plik jest zbyt duży, maksymalny rozmiar to " + maxSize + " kB";
            },
            async persist(avatar) {
                this.isUploading = true;

                let data = new FormData();

                data.append('avatar', avatar);

                await axios.post('/api/uzytkownicy/' + this.user.id + '/avatars', data)
                    .then(response => {
                        this.isDefaultAvatar ? flash('Dodano avatar') : flash('Zmieniono avatar');
                        this.avatar = '/storage/' + response.data.url;
                    }).catch(error => flash(error.response.data.errors.avatar[0], 'danger'))
                    .finally(() => {
                        this.isUploading = false;
                    });
            },
            destroy() {
                axios.delete('/api/uzytkownicy/' + this.user.id + '/avatars')
                    .then(() => {
                        this.avatar = '/storage/avatars/notfound.jpg';
                        flash('Avatar usunięty');
                    })
                    .catch(error => flash(error.response.data.errors.photo[0], 'danger'));
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

</style>