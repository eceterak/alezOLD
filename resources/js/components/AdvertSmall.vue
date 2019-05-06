<template>
    <article class="card lg:flex mb-4">
        <div class="flex lg:static lg:w-1/8 items-center justify-center mb-0 lg:mb-0 sm:mb-2">
            <img src="/storage/notfound.png">
        </div>
        <div class="lg:static lg:w-7/8 lg:pl-2">
            <div class="flex justify-between">
                <h3 class="font-normal text-lg mb-2"><a href="">Hi world</a></h3>
                <button @click="favourite = true"><i class="far fa-star" :class="{'fas': favourite}"></i></button>
            </div>
            <section>
                <p class="text-grey-darker">Lorem ipsum, dolor sit amet consectetur adipisicing elit. Est nisi delectus ex molestias cumque iste, voluptates exercitationem modi laboriosam sapiente quisquam culpa distinctio saepe tempora, aut a, magnam facilis dolorum.</p>
            </section>
        </div>
    </article>
</template>

<script>
    export default {
        data() {
            return {
                image: '/storage/notfound.png',
                favourite: false
            };
        },

        created() {
            this.favourite = localStorage.getItem('favourite') || false;
        },

        watch: {
            favourite() {
                console.log(this.favourite);

                localStorage.setItem('favourite', this.favourite);
            }
        }
    }
</script>
