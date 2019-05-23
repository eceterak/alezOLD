<template>
    <div class="inline-block dropdown" v-if="notifications.length">
        <span class="text-teal mr-4"><i class="far fa-bell"></i></span>
        <ul class="dropdown-content list-reset w-48">
            <li v-for="notification in notifications" v-bind:key="notification.data.id">
                <a :href="notification.data.link" v-text="notification.data.message" @click="markAsRead(notification)"></a>
            </li>
        </ul>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                notifications: false
            }
        },

        computed: {

        },

        created() {
            axios.get('/uzytkownicy/' + window.App.user.name + '/notyfikacje')
                .then(response => this.notifications = response.data);
        },

        methods: {
            markAsRead(notification) {
                axios.delete('/uzytkownicy/' + window.App.user.name + '/notyfikacje/' + notification.id);
            }
        }
    }
</script>

