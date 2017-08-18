<template>
    <div id="map" style="margin:30px auto; width: 80%; height: 600px;"></div>
</template>

<script>
    var L = require('leaflet');

    export default {
        mounted() {
            var map = L.map('map').setView([
                39.466667, -0.375
            ], 15);

            L.tileLayer('https://cartodb-basemaps-{s}.global.ssl.fastly.net/light_all/{z}/{x}/{y}.png', {
                maxZoom: 18, 
                attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>, &copy; <a href="https://carto.com/attribution">CARTO</a>'
            }).addTo(map);

            var greenIcon = L.icon({
                iconUrl: 'https://image.flaticon.com/icons/svg/75/75684.svg',

                iconSize:     [38, 38], // size of the icon
                shadowSize:   [0, 0], // size of the shadow
                iconAnchor:   [0, 0], // point of the icon which will correspond to marker's location
                shadowAnchor: [4, 62],  // the same for the shadow
                popupAnchor:  [-3, -76] // point from which the popup should open relative to the iconAnchor
            });

            L.marker([39.466667, -0.375], {icon: greenIcon}).addTo(map);
        }

    }
</script>
