<template>
    <div>
        <div class="grid">
            <div class="map">
                <div v-if="activeTweet" class="mt-05 mb-05 ml-05 fill-darker rounded p-05" :class="{ 'fill-red color-lighter': activeTweetToday }">
                    <p class="mt-05 mb-05 text-medium">
                        <span v-if="activeTweetToday">Hoy, </span>
                        <span v-text="parseDate(activeTweet.date)"></span>
                    </p>
                    <p class="mt-05 mb-05 text-small"><span v-html="parseTweet(activeTweet.text)"></span></p>
                </div>
                <div id="map" class="mb-05 ml-05 rounded"></div>
            </div>

            <div v-if="tweets" class="tweet-list">
                <div>
                    <div v-for="tweet in tweets.data" @click="selectTweet(tweet)" style="cursor: pointer" class="fill-darker rounded m-05 p-1">
                        <span><span v-text="parseDate(tweet.date)" class="text-medium"></span> <small class="text-small color-orange">({{ tweet.streets.length }} {{ pluralise(tweet.streets.length, 'localización', 'localizaciónes') }})</small></span>
                        <div v-if="activeTweet == tweet">
                            <p v-html="parseTweet(tweet.text)" class="text-small text-italic color-faded"></p>
                            <div class="p-05">
                                <ul class="street-list color-blue">
                                    <li v-for="street in tweet.streets" v-text="street.name"></li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="page-status text-small mt-1">
                        {{ tweetDateRange }}
                    </div>

                    <div class="pagination p-1 text-small">
                        <button class="prev button" @click="fetchTweets(tweets.next_page_url)" :disabled="tweets.next_page_url ? false : true">más antiguas</button>
                        <button class="next button" @click="fetchTweets(tweets.prev_page_url)" :disabled="tweets.prev_page_url ? false : true">más recientes</button>
                    </div>

                </div>

                <div class="credits">
                    <p class="text-small color-faded">&copy; 2017 <a href="https://lumby.me/" target="_blank">Oliver Lumby</a>. Tweets: <a href="https://twitter.com/policialocalvlc" target="_blank">@policialocalvlc</a></p>
                    <a class="no-underline" href="https://github.com/olumby/radar">
                        <svg class="fill-light" width="26" height="26" viewBox="0 0 1792 1792" xmlns="http://www.w3.org/2000/svg">
                            <path d="M896 128q209 0 385.5 103t279.5 279.5 103 385.5q0 251-146.5 451.5t-378.5 277.5q-27 5-40-7t-13-30q0-3 .5-76.5t.5-134.5q0-97-52-142 57-6 102.5-18t94-39 81-66.5 53-105 20.5-150.5q0-119-79-206 37-91-8-204-28-9-81 11t-92 44l-38 24q-93-26-192-26t-192 26q-16-11-42.5-27t-83.5-38.5-85-13.5q-45 113-8 204-79 87-79 206 0 85 20.5 150t52.5 105 80.5 67 94 39 102.5 18q-39 36-49 103-21 10-45 15t-57 5-65.5-21.5-55.5-62.5q-19-32-48.5-52t-49.5-24l-20-3q-21 0-29 4.5t-5 11.5 9 14 13 12l7 5q22 10 43.5 38t31.5 51l10 23q13 38 44 61.5t67 30 69.5 7 55.5-3.5l23-4q0 38 .5 88.5t.5 54.5q0 18-13 30t-40 7q-232-77-378.5-277.5t-146.5-451.5q0-209 103-385.5t279.5-279.5 385.5-103zm-477 1103q3-7-7-12-10-3-13 2-3 7 7 12 9 6 13-2zm31 34q7-5-2-16-10-9-16-3-7 5 2 16 10 10 16 3zm30 45q9-7 0-19-8-13-17-6-9 5 0 18t17 7zm42 42q8-8-4-19-12-12-20-3-9 8 4 19 12 12 20 3zm57 25q3-11-13-16-15-4-19 7t13 15q15 6 19-6zm63 5q0-13-17-11-16 0-16 11 0 13 17 11 16 0 16-11zm58-10q-2-11-18-9-16 3-14 15t18 8 14-14z"/>
                        </svg>
                    </a>
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

                return false;x
            },
            tweetDateRange: function() {
                if (this.tweets.data && _.first(this.tweets.data) && _.last(this.tweets.data)) {
                    return this.parseDateShort(_.last(this.tweets.data).date) + " - " + this.parseDateShort(_.first(this.tweets.data).date)
                }
            }
        },

        methods: {
            fetchTweets: function(page = '') {
                this.$axios.get('/tweets' + page).then(function (response) {
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
                    padding: [50, 50],
                    maxZoom: 14
                });
            },

            parseDate: function(date) {
                return this.$moment(date).locale('es').format('dddd DD MMMM YYYY');
            },

            parseDateShort: function(date) {
                return this.$moment(date).locale('es').format('DD/MM/YYYY');
            },

            parseTweet: function(text) {
                text = text.replace(/#(\S*)/g,'<a class="tweet-hashtag" href="http://twitter.com/#!/search/$1">#$1</a>');
                text = text.replace(/@(\S*)/g,'<a class="tweet-mention" href="http://twitter.com/$1">@$1</a>');
                return text.replace(/(^|&lt;|\s)(((https?|ftp):\/\/|mailto:).+?)(\s|&gt;|$)/g, '$1<a class="tweet-link" target="_blank"  href="$2">$2</a>$5');
            },

            pluralise: function(count, singular, plural) {
                if (count == 1) {
                    return singular;
                }

                return plural;
            }
        }

    }
</script>
