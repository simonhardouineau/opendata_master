<!doctype html>
<html lang="en">
<head>
    <link rel="stylesheet" href="http://openlayers.org/en/v3.12.1/css/ol.css" type="text/css">
    <style>
        .map {
            height: 400px;
            width: 100%;
        }
    </style>
    <script src="http://openlayers.org/en/v3.12.1/build/ol.js" type="text/javascript"></script>
    <title>OpenLayers 3 example</title>
</head>
<body>
<h2>My Map</h2>
<div id="map" class="map"></div>
<script type="text/javascript">
    var myStyle= {fillColor: "rgba(255,0,0,1)"};

    var vector = new ol.layer.Vector({
        source: new ol.source.Vector({
            url: 'data/doc.kml',
            format: new ol.format.KML(),
            style: new ol.style.Style({
                stroke: new ol.style.Stroke({
                        color: "#f00",
                        width: 1
                }),
                fill: new ol.style.Fill({
                        color: "rgba(255,0,0,1)"
                })
            })
        })
    });

    var map = new ol.Map({
        target: 'map',
        layers: [
            new ol.layer.Tile({
                source: new ol.source.OSM()
            }), vector
        ],
        view: new ol.View({
            center: ol.proj.fromLonLat([-0.581336, 44.839976]),
            zoom: 10
        })
    });
</script>
</body>
</html>