<?php if (false) { ?><script>
        <?php } ?>

        var du_map, du_geoLayer, du_tileLayer, du_userIcon = false;
        var du_markers = [];
        var polygonLayer = [];
        var osm = {
            'tl': 'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',
            'at': '&copy; <a href="http://osm.org/copyright">OpenStreetMap</a> contributors',
            'z': 19
        };

        function du_mapLoad(data) {
            du_map = L.map('du-canvas').setView([54.5, -3], 5);
            if (!du_tileLayer) {
                du_tileLayer = L.tileLayer(osm.tl, {
                    attribution: osm.at,
                    maxZoom: osm.z
                })
            }
            du_map.addLayer(du_tileLayer);
            du_geoData(data);
            icons();
        }

        function du_geoData(data) {
            if (du_geoLayer) {
                du_map.removeLayer(du_geoLayer);
                du_geoLayer = false;
            }

            du_geoLayer = L.geoJson(data, {
                style: du_setMapStyle,
                onEachFeature: du_mapOnEachFeature
            }).addTo(du_map);
        }

        function du_setMapStyle() {
            var opacity = 0.4
            return {
                weight: 2,
                color: "#000",
                opacity: opacity,
                fillColor: "#de6e18",
                fillOpacity: opacity
            }
        }

        function du_mapOnEachFeature(feature, layer) {
            layer.on('click', function(e) {
                // removeMarker();
                clickedLayer = feature.properties.LAD;
                // console.log(clickedLayer)
                // addArea(true, clickedLayer);
            });
        }

        function icons() {
            removeMarker()
            var data = {
                user: `<?php echo $baseUrl['img'] ?>du_<?php echo $projName['bodyId'] ?>_icon.png`,
                iSize: [30, 30],
                iAnchor: [15, -15]
            }

            var iconOptions = L.Icon.extend({
                options: {
                    iconSize: data.iSize,
                    iconAnchor: data.iAnchor
                }
            });
            du_userIcon = new iconOptions({
                iconUrl: data.user
            });
        }

        function addMarker(lat, long, toolText, data) {
            var popup = L.popup()
                .setContent(`<b>${toolText.name}</b>
                            <p>Reported burglaries in 2021-22: <span class="du-bold-data">${toolText["2021-22"]}</span></p> 
                            <p>Reported burglaries in 2020-21: <span class="du-bold-data">${toolText["2020-21"]}</span></p> 
                            <p>Rank: <span class="du-bold-data">${ordinal_suffix_of(toolText.rank)}</span></p> 
                            `);

            var marker = L.marker([lat, long], {
                    icon: du_userIcon
                })
                .addTo(du_map)
            marker.bindPopup(popup, {
                permanent: true,
                className: "du-popup",
                area: toolText.name,
                rank: toolText.rank,
                data: data,
                "2020-21": toolText["2020-21"],
                "2021-22": toolText["2021-22"]
            }).on('click', clickZoom);
            du_markers.push(marker)
            // setMapView(lat, long)
        }

        function removeMarker() {
            du_markers.forEach(marker => {
                du_map.removeLayer(marker);
            });
            du_markers = [];
        }

        function setMapView(Lat, Long) {
            // du_map.setView([Lat, Long], 10);
            du_map.fitBounds([Lat, Long]);
            // du_map.setMaxBounds([Lat, Long]);
        }

        function clickZoom(e) {
            du_map.setView(e.target.getLatLng(), 11);
            // console.log(e.target)
            du_animateSlider(e.target._popup.options.area, e.target._popup.options.data);
            du_buildTable(e.target._popup.options.area, e.target._popup.options.data)
            jq("#du-2020-21", mainEl).text(e.target._popup.options["2020-21"]);
            jq("#du-2021-22", mainEl).text(e.target._popup.options["2021-22"]);
        }

        function addSearch(area) {
            var correctOrder = [];
            // console.log(Array.isArray(area))
            area.forEach(set => {
                correctOrder.push([set[1], set[0]])
            })
            var polygon = L.polygon(
                correctOrder
            ).setStyle({color: '#363b59'}).addTo(du_map);

            polygonLayer.push(polygon);
        }

        function removePolygon() {
            polygonLayer.forEach(layer => {
                du_map.removeLayer(layer);
            });
            polygonLayer = [];
        }