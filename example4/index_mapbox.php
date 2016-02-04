<!doctype html>
<html lang="en">
<head>
    <link rel="stylesheet" href="http://openlayers.org/en/v3.12.1/css/ol.css" type="text/css">
    <style>
        .map {
            height: 600px;
            width: 100%;
        }
    </style>
    <script src='https://api.tiles.mapbox.com/mapbox-gl-js/v0.12.3/mapbox-gl.js'></script>
    <link href='https://api.tiles.mapbox.com/mapbox-gl-js/v0.12.3/mapbox-gl.css' rel='stylesheet' />
    <title>Mapbox example</title>
</head>
<body>
<h2>My Map</h2>
<div id="map" class="map"></div>


<script src="//code.jquery.com/jquery-1.12.0.min.js"></script>
<script src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
<script type="text/javascript">
    mapboxgl.accessToken = 'pk.eyJ1IjoiYWRyZ2F1dGllciIsImEiOiJjaWpvYzVmaGkwMDVwdzFtM21zdGp3ODgwIn0.Oh2q_9SaqPeiOd78WYocug';
    var map = new mapboxgl.Map({
        container: 'map', // container id
        style: 'mapbox://styles/mapbox/streets-v8', //stylesheet location
        center: [-0.67, 44.84], // starting position
        zoom: 9 // starting zoom
    });


    map.on('style.load', function () {
        $.ajax({
            dataType: "json",
            url: "data/doc.geojson",
            success: function(data){
                /*
                map.addSource('features',{
                    'type': 'geojson',
                    'data':  data});

                map.addLayer({
                    'id': 'zones',
                    'type': 'fill',
                    'source': 'features',
                    'layout': {},
                    'paint': {
                        'fill-color': '#088',
                        'fill-opacity': 0.8
                    }});
                */


                data["features"].forEach(function(feature,index){
                    map.addSource('feature'+index,{
                        'type': 'geojson',
                        'data':  feature});

                    map.addLayer({
                        'id': 'zone'+index,
                        'type': 'fill',
                        'source': 'feature'+index,
                        'layout': {},
                        'paint': {
                            'fill-color': '#088',
                            'fill-opacity': 0.8
                        }
                    });
                });

            }
        });

    });
</script>
</body>
</html>