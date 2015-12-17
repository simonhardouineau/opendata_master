<?php
?>

<html>
    <head>
        <title>Show Data</title>
        <style>
            #container{
                min-width: 100vw;
                height: 100vh;
                overflow: scroll;
            }

            #container>b{
                position: relative;
                display: inline-block;
                width: 10px;
                margin: 0 10px;
                background-color: #000;
                word-wrap: nowrap;
            }
        </style>
    </head>
    <body>
        <div id="container">

        </div>
    <script src="vendor/d3/d3.min.js"></script>
    <script>
        var json;
        d3.json("script_json.php",function(data){
            json = data;
            console.log(json);
            display();
        });

        var container = d3.select("#container");

        var display = function(){
            // Update…
            var b = container.selectAll("b")
                .data(json)
                .style("height", function(d) { return d.places*10 + "px"; });

            // Enter…
            b.enter().append("b")
                .style("height", function(d) { return d.places*10 + "px"; });

            // Exit…
            b.exit().remove();
        }

    </script>
    </body>
</html>
