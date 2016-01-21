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
<div id="info">&nbsp;</div><input id="color" type="button" value="Colorer" />
<script src="//code.jquery.com/jquery-1.12.0.min.js"></script>
<script src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
<script type="text/javascript">
    var vector = new ol.source.Vector({
        url: 'data/doc.geojson',
        format: new ol.format.GeoJSON(),
    });

    var map = new ol.Map({
        layers: [
            new ol.layer.Tile({
                source: new ol.source.OSM()
            }),
            new ol.layer.Image({
                source: new ol.source.ImageVector({
                    source: vector,
                    style: new ol.style.Style({
                        fill: new ol.style.Fill({
                            color: 'rgba(255, 255, 255, 0.5)'
                        }),
                        stroke: new ol.style.Stroke({
                            color: "rgba(58, 137, 35, 1)",
                            width: 1
                        })
                    })
                })
            })
        ],
        target: 'map',
        view: new ol.View({
            center: ol.proj.fromLonLat([-0.581336, 44.839976]),
            zoom: 10
        })
    });

    var styleRed = new ol.style.Style({
        fill: new ol.style.Fill({ color: "rgba(198, 8, 0, 0.5)" }),
        stroke: new ol.style.Stroke({ color: "rgba(198, 8, 0, 1)" })
    });

    var styleBlack = new ol.style.Style({
        fill: new ol.style.Fill({ color: "rgba(0, 0, 0, 0.5)" }),
        stroke: new ol.style.Stroke({ color: "rgba(0, 0, 0, 1)" })
    });

    var styleGreen = new ol.style.Style({
        fill: new ol.style.Fill({ color: "rgba(58, 137, 35, 0.5)" }),
        stroke: new ol.style.Stroke({ color: "rgba(58, 137, 35, 1)" })
    });


    var arrayFeatures = [];

    vector.on('change', function(evt) {
        if(vector.getState() === 'ready'){
            var compt = 0;

            vector.forEachFeature(function(feature){
                if(compt < 5){
                    feature.setProperties({'color' : 'red'});
                }
                else{
                    feature.setProperties({'color' : 'green'});
                }

                arrayFeatures[feature.get("GID")] = feature;
                compt++;
            });
        }
    });


    var functionColor = function(){
        arrayFeatures.forEach(function(feature){
            switch(feature.get('color')){
                case 'red' :
                    feature.setStyle(styleRed);
                    break;
                case 'green' :
                    feature.setStyle(styleGreen);
                    break;
                case 'black' :
                    feature.setStyle(styleBlack);
                    break;
                default :
                    break;
            }

        })
    };

    setTimeout(functionColor, 1000);

    var highlight;
    var displayFeatureInfo = function(pixel) {
        var feature = map.forEachFeatureAtPixel(pixel, function(feature, layer) {
            return feature;
        });

        var info = document.getElementById('info');
        if (feature) {
            info.innerHTML = feature.get('NOM');
        } else {
            info.innerHTML = '&nbsp;';
        }

    };

    map.on('pointermove', function(evt) {
        if (evt.dragging) {
            return;
        }
        var pixel = map.getEventPixel(evt.originalEvent);
        displayFeatureInfo(pixel);
    });



</script>
</body>
</html>

<?php

/*

red : 198,8,0
vert : 58,137,35
noir : 0,0,0,0.8

*/