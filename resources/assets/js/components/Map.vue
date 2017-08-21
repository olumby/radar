<template>
    
    <div>
        <p>Latest Tweet: </p>
        <p>Tweet Info: </p>
        <div id="map" style="margin:30px auto; width: 80%; height: 600px;"></div>
        <p>Report Issue</p>


        <div style="margin:30px auto; width: 80%; height: 600px;">
            <p v-for="tweet in tweets.data" @click="selectTweet(tweet)" style="cursor: pointer" class="fill-darker p-05">
                <span v-text="parseDate(tweet.date)" style="width: 350px; display: inline-block"></span>
                <span>Radar on {{ tweet.streets.length }} Streets</span>
            </p>
        </div>
    </div>

</template>

<script>
    var L = require('leaflet');

    export default {

        data () {
            return {
                map: Object,
                radarIcon: L.icon({
                    iconUrl: '/radar.svg',
                    iconSize: [38, 38],
                    shadowSize: [0, 0],
                    iconAnchor: [19, 4]
                }),
                tweets: {},
                markers: []
            };
        },

        mounted() {
            this.fetchTweets();

            this.map = L.map('map').setView([
                39.466667,
                -0.375
            ], 14);

            L.tileLayer('https://cartodb-basemaps-{s}.global.ssl.fastly.net/light_all/{z}/{x}/{y}.png', {
                maxZoom: 18, 
                attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>, &copy; <a href="https://carto.com/attribution">CARTO</a>'
            }).addTo(this.map);
        },

        methods: {
            fetchTweets: function() {
                this.$axios.get('/tweets').then(function (response) {
                    this.tweets = response.data;
                    this.selectTweet(this.tweets.data[0]);
                }.bind(this)).catch(function (error) {
                    console.log(error);
                });
            },

            selectTweet: function(tweet) {
                _.each(this.markers, function (marker, key) {
                    this.map.removeLayer(marker);
                }.bind(this));

                this.markers = [];

                _.each(tweet.streets, function (street) {
                    this.markers.push(L.marker(street.point, {icon: this.radarIcon}).addTo(this.map));
                }.bind(this));

                this.map.fitBounds(L.featureGroup(this.markers).getBounds(), {
                    padding: [10, 10],
                    maxZoom: 15
                });
            },

            parseDate: function(date) {
                return this.$moment(date).calendar(null, {
                    sameDay: '[Today]',
                    nextDay: '[Tomorrow]',
                    nextWeek: 'dddd',
                    lastDay: '[Yesterday]',
                    lastWeek: 'ddd DD MMMM YYYY',
                    sameElse: 'ddd DD MMMM YYYY'
                });
            }
        }

    }
</script>
