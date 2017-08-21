<script>
    var L = require('leaflet');

    export default {

        props: {
            dataStreets: Array,
        },

        data () {
            return {
                streets: {},
                streetPoints: {},
                activeStreet: "",
                settingPoint: false,
                map: Object,
                radarIcon: L.icon({
                    iconUrl: '/radar.svg',
                    iconSize:     [38, 38],
                    shadowSize:   [0, 0],
                    iconAnchor:   [19, 4]
                })
            };
        },

        mounted() {
            this.map = L.map('map').setView([
                39.466667, -0.375
            ], 14);

            L.tileLayer('https://cartodb-basemaps-{s}.global.ssl.fastly.net/light_all/{z}/{x}/{y}.png', {
                maxZoom: 18, 
                attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>, &copy; <a href="https://carto.com/attribution">CARTO</a>'
            }).addTo(this.map);

            // L.marker([39.49933027726959, -0.3754534386098385], {icon: this.radarIcon}).addTo(this.map);

            _.each(this.dataStreets, function(street) {
                L.marker(street.point, {icon: this.radarIcon}).addTo(this.map);
            }.bind(this));

            this.map.on("click", this.readPos);
        },

        methods: {
            setPoint: function(street) {
                this.activeStreet = street;
                this.settingPoint = true;
            },

            getPoints: function() {
                console.log(JSON.stringify(this.streets));
            },

            readPos: function(e) {
                if (this.activeStreet != "" && this.settingPoint) {
                    if (this.streetPoints[this.activeStreet]) {
                        this.map.removeLayer(this.streetPoints[this.activeStreet]);
                    }
                    this.streetPoints[this.activeStreet] = L.circle([e.latlng.lat, e.latlng.lng], 20).addTo(this.map);
                    this.$set(this.streets, this.activeStreet, [parseFloat((e.latlng.lat).toFixed(7)), parseFloat((e.latlng.lng).toFixed(6))])
                }
            }
        }

    }
</script>
