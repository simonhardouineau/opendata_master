<!doctype html>
<html lang="fr">
<head>
    <link rel="stylesheet" href="../vendor/ol3/ol.css" type="text/css">
    <style>
        .map {
            height: 100%;
            width: 100%;
        }
    </style>
    <script src="../vendor/ol3/ol.js" type="text/javascript"></script>
    <script src="../vendor/chroma-js/chroma.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
    <title>Map vcub</title>
</head>
<body>
<div id="map" class="map"></div>
<script type="text/javascript">

    $("document").ready(function() {


        var scale = chroma.scale(['#ff5354', '#ffc147', '#70f990', '#83e0ea', '#8177cd']).mode('lab').domain([.10, .30, .50,.70, .90]),
            $marker;
            $.get('data/marker.svg', function(svg){
                $marker = $(svg);

                var getIcon = function(value) {
                    var $tmp_marker = $marker.clone(),
                        $tmp_steps = $tmp_marker.find("#range").find("ellipse, path");
                    $tmp_steps.each(function(index, step) {
                        console.log(value,$tmp_steps.length)
                        if (index >= value*$tmp_steps.length) {

                            $(step).attr("fill", "none");
                            if (index == value) {
                                $(step).attr("fill", scale(value).brighten().hex());
                            }
                        } else {
                            $(step).attr("fill", scale(value).hex());

                        }
                    });

                    return btoa(new XMLSerializer().serializeToString($tmp_marker[0]));

                };

                $.getJSON( "data/requete_stations.php", function( data ) {
                    var stations = data;

                    var iconFeatures = [];

                    var iconFeature;

                    var getIconStyle = function(ratio){

                        var b64icon = getIcon(ratio);

                        var iconStyle = new ol.style.Style({
                            image: new ol.style.Icon(/** @type {olx.style.IconOptions} */ ({
                                anchor: [.5, 128],
                                anchorXUnits: 'fraction',
                                scale:.5,
                                anchorYUnits: 'pixels',
                                opacity: 1,
                                src: 'data:image/svg+xml;base64,'+b64icon
                            }))
                        });

                        return iconStyle;
                    };

                    stations.forEach(function(station){

                        var coords = station.coord.split(" ");

                        iconFeature = null;

                        iconFeature = new ol.Feature({
                            geometry: new ol.geom.Point(ol.proj.transform([parseFloat(coords[1]), parseFloat(coords[0])], 'EPSG:4326', 'EPSG:3857')),
                            name: station.nom,
                            ratio: 0.5
                        });
                        iconFeatures.push(iconFeature);

                        iconFeature.setStyle(getIconStyle(Math.random()));


                    });

                    var vectorSource = new ol.source.Vector({
                        features: iconFeatures
                    });

                    var vectorLayer = new ol.layer.Vector({
                        source: vectorSource,
                        rendererOptions: {yOrdering: true},
                    });

                    var map = new ol.Map({
                        target: 'map',
                        layers: [
                            new ol.layer.Tile({
                                source: new ol.source.OSM()
                            }),
                            vectorLayer

                        ],
                        view: new ol.View({
                            center: ol.proj.fromLonLat([-0.578760, 44.835731]),
                            zoom: 13
                        })
                    });

                });


            }, 'text');
    });


</script>
</body>
</html>