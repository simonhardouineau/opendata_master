<?php
?>

<html>
    <head>
        <title>Show Data</title>
        <style>
            #container{
                min-width: 100vw;
                height: 100vh;
            }

            .bar{
                position: relative;
                z-index: 1;
                display: inline-block;
                width: 4px;
                margin: 0 4px;
                height: 150px;
                background-color: #aaa;


            }
            .bar>b{
                position: absolute;
                left: 0;
                z-index: 2;
                bottom: 0;
                display: block;
                width: 100%;

                background-color: #000;
            }
        </style>
    </head>
    <body>
        <div id="container">

        </div>
    <script src="../vendor/d3/d3.min.js"></script>
    <script>
        var json;
        d3.json("data/script_json.php",function(data){
            json = data;
            display();
        });

        var container = d3.select("#container");

        var display = function(){
            // Update…
            var b = container.selectAll(".bar>b")
                .data(json)
                .style("height", pourcentPlace);

            // Enter…
            b.enter().append("div")
                .attr("class","bar")
                .append("b")
                .style("height", pourcentPlace);

            // Exit…
            b.exit().remove();
        }

        var pourcentPlace = function(d) {
            var pourcent = (d.places/(d.places + d.velos)) * 1500;
            return pourcent == NaN ? 0 : pourcent ;
        };

    </script>
    </body>
</html>
