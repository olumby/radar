<template>
    <div>
        <div class="grid">
            <div class="map">
                <div v-if="activeTweet" class="mt-05 mb-05 ml-05 fill-darker rounded p-05" :class="{ 'fill-red color-light': activeTweetToday }">
                    <p class="mt-05 mb-05 text-medium"><span v-text="parseDate(activeTweet.date)"></span> <span v-if="activeTweetToday" class="color-faded">(hoy)</span></p>
                    <p class="mt-05 mb-05 text-small"><span v-html="parseTweet(activeTweet.text)"></span></p>
                </div>
                <div id="map" class="mb-05 ml-05 rounded"></div>
            </div>

            <div class="tweet-list">
                <div v-for="tweet in tweets.data" @click="selectTweet(tweet)" style="cursor: pointer" class="fill-darker rounded m-05 p-1">
                    <span><span v-text="parseDate(tweet.date)" class="text-medium"></span> <small class="text-small color-orange">({{ tweet.streets.length }} sitios)</small></span>
                    <div v-if="activeTweet == tweet">
                        <p v-html="parseTweet(tweet.text)" class="text-small text-italic color-faded"></p>
                        <div class="p-05">
                            <ul class="street-list color-blue">
                                <li v-for="street in tweet.streets" v-text="street.name"></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
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
                markers: [],
                activeIndex: 0,
            };
        },

        mounted() {
            this.fetchTweets();

            this.$moment.locale('es');

            this.map = L.map('map').setView([
                39.466667,
                -0.375
            ], 14);

            L.tileLayer('https://cartodb-basemaps-{s}.global.ssl.fastly.net/light_all/{z}/{x}/{y}.png', {
                maxZoom: 18, 
                attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>, &copy; <a href="https://carto.com/attribution">CARTO</a>'
            }).addTo(this.map);

            this.$nextTick(function() {
                this.map.invalidateSize();
            });
        },

        computed: {
            activeTweet: function() {
                if (this.tweets.data && this.tweets.data[this.activeIndex])
                    return this.tweets.data[this.activeIndex]
            },
            activeTweetToday: function() {
                if (this.activeTweet && this.$moment(this.activeTweet.date).isSame(Date.now(), 'day')) {
                    return true;
                }

                return false;
            }
        },

        methods: {
            fetchTweets: function() {
                this.$axios.get('/tweets').then(function (response) {
                    this.tweets = response.data;
                    if (this.tweets.data[0]) {
                        this.selectTweet(this.tweets.data[0]);
                    }
                }.bind(this)).catch(function (error) {
                    console.log(error);
                });
            },

            selectTweet: function(tweet) {
                _.each(this.markers, function (marker, key) {
                    this.map.removeLayer(marker);
                }.bind(this));

                this.markers = [];

                this.activeIndex = this.tweets.data.indexOf(tweet);

                _.each(tweet.streets, function (street) {
                    this.markers.push(L.marker(street.point, {icon: this.radarIcon}).addTo(this.map));
                }.bind(this));

                this.map.fitBounds(L.featureGroup(this.markers).getBounds(), {
                    padding: [10, 10],
                    maxZoom: 15
                });
            },

            parseDate: function(date) {
                return this.$moment(date).locale('es').format('dddd DD MMMM YYYY');
            },

            parseTweet: function(text) {
                text = text.replace(/#(\S*)/g,'<a class="tweet-hashtag" href="http://twitter.com/#!/search/$1">#$1</a>');
                text = text.replace(/@(\S*)/g,'<a class="tweet-mention" href="http://twitter.com/$1">@$1</a>');
                return text.replace(/(^|&lt;|\s)(((https?|ftp):\/\/|mailto:).+?)(\s|&gt;|$)/g, '$1<a class="tweet-link" target="_blank"  href="$2">$2</a>$5');
            }
        }

    }
</script>
