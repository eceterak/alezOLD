<template>
    <div>
        <form v-if="canUpdate" method="POST" enctype="multipart/form-data">
            <image-upload name="avatar" @loaded="onLoad"></image-upload>
            <button class="btn btn-primary">Dodaj avatar</button>
        </form>
        <img :src="avatar" class="rounded-full w-32">
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
                axios.post('/api/uzytkownicy/' + this.user.name + '/avatars', data)
                    .then(() => flash('Dodano avatar.'));
            }
        }
    }
</script>

