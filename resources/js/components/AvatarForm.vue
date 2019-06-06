<template>
    <div>
        <div class="d-flex position-relative justify-content-center align-items-center mb-4">
            <p class="position-absolute p-2" style="top: 0; right: 0;" v-if="!isDefaultAvatar">
                <a href="#" @click.prevent="destroy"><i class="fas fa-times"></i></a>
            </p>
            <img :src="avatar" class="img-fluid">
        </div>
        <form v-if="canUpdate" method="POST" enctype="multipart/form-data">
            <image-upload name="avatar" @loaded="onLoad" :btnText="(isDefaultAvatar) ? 'dodaj avatar' : 'zmień avatar'"></image-upload>
        </form>
    </div>
</template>

<script>
    import ImageUpload from './ImageUpload.vue';
    
    export default {

        props: ['user'],

        components: { ImageUpload },

        data() {
            return {
                avatar: this.user.avatar_path
            };
        },

        computed: {
            canUpdate() {
                return this.authorize(user => user.id === this.user.id)
            },
            isDefaultAvatar() {
                return this.avatar == '/storage/avatars/notfound.jpg';
            }
        },

        methods: {
            onLoad(avatar) {
                this.avatar = avatar.src;

                this.persist(avatar.file);
            },

            persist(avatar) {
                let data = new FormData();

                data.append('avatar', avatar);
                axios.post('/api/uzytkownicy/' + this.user.id + '/avatars', data)
                    .then(() => flash('Dodano avatar'));
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

.avatar {
    height: 10rem;
    width: 10rem;
}

</style>


