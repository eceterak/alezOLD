<template>
    <div id="map"></div>
</template>

<script>
    import GoogleMaps from 'google-maps'

    export default {
        props: [
            'lat',
            'lon',
            'api'
        ],

        mounted() {
            GoogleMaps.KEY = 'AIzaSyCIGt4_PBVT77N2e6is2UPyTi-5MfPzazM';
            GoogleMaps.VERSION = '3.35';
            GoogleMaps.LANGUAGE = 'pl';
            GoogleMaps.REGION = 'pl';

            GoogleMaps.load(google => {

                var latlon = new google.maps.LatLng(this.lat, this.lon);
                
                let map = new google.maps.Map(document.getElementById('map'), {
                    zoom: 15,
                    center: latlon
                });

                let marker = new google.maps.Circle({
                    center: latlon,
                    map: map,
                    radius: 300,
                    strokeColor: '#078080',
                    strokeOpacity: 0.6,
                    strokeWeight: 1,
                    fillColor: '#078080',
                    fillOpacity: 0.3
                })
            });
        }
    }
</script>
<style scoped>
    #map {
        height: 15rem;
        width: 100%;
    }
</style>

