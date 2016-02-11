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
    <script src='https://api.mapbox.com/mapbox.js/v2.2.4/mapbox.js'></script>
    <link href='https://api.mapbox.com/mapbox.js/v2.2.4/mapbox.css' rel='stylesheet' />
    <title>Example 6</title>
</head>
<body>
<h2>My Map</h2>
<div id="map" class="map"></div>


<script src="//code.jquery.com/jquery-1.12.0.min.js"></script>
<script src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
<script type="text/javascript">
    /*mapboxgl.accessToken = 'pk.eyJ1IjoiYWRyZ2F1dGllciIsImEiOiJjaWpvYzVmaGkwMDVwdzFtM21zdGp3ODgwIn0.Oh2q_9SaqPeiOd78WYocug';


    var map = new mapboxgl.Map({
        container: 'map', // container id
        style: 'mapbox://styles/mapbox/streets-v8', //stylesheet location
        center: [-0.67, 44.84], // starting position
        zoom: 9 // starting zoom
    });*/

    // Provide your access token
    L.mapbox.accessToken = 'pk.eyJ1IjoiYWRyZ2F1dGllciIsImEiOiJjaWpvYzVmaGkwMDVwdzFtM21zdGp3ODgwIn0.Oh2q_9SaqPeiOd78WYocug';
    // Create a map in the div #map
    var map = L.mapbox.map('map', 'mapbox.streets');
    // Set View
    map.setView([-0.67, 44.84],9);

    map.on('style.load', function () {
        $.ajax({
            dataType: "json",
            url: "data/doc.geojson",
            success: function(data){



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