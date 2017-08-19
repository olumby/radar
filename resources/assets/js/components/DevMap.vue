<script>
    var L = require('leaflet');

    export default {
        data () {
            return {
                streets: [],
                activeStreet: "",
                settingPath: false,
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

            L.marker([39.49933027726959, -0.3754534386098385], {icon: this.radarIcon}).addTo(this.map);

            this.map.on("click", this.readPos);

        },

        methods: {
            setPath: function(street) {
                this.activeStreet = street;
                this.settingPath = true;
            },

            getPath: function(street) {

            },

            readPos: function(e) {
                console.log(e.latlng.lat, e.latlng.lng);
                L.circle([e.latlng.lat, e.latlng.lng], 200).addTo(this.map);
            }
        }

    }
</script>
