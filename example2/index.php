<?php
?>

<html>
    <head>
        <title>Example 2</title>
        <style>

            html, body{
                margin: 0;
                padding: 0;
            }
            #container{
                min-width: 100vw;

            }

            .bar{
                position: relative;
                z-index: 1;
                display: inline-block;
                width: 12px;
                border-radius: 6px;
                margin:2px;
                height: 150px;
                background-color: #ddd;
                overflow: hidden;
                cursor: pointer;
            }


            .bar>b{
                position: absolute;
                left: 0;
                z-index: 2;
                bottom: 0;
                display: block;
                width: 100%;
                height: 0;

                background-color: rgba(90, 137, 186, 0.75);

                transition: height .6s, background .6s;
            }
            
            .bar.active>b{
                background-color: orangered;
            }

            #viewer>.bar{
                width: 30px;
                height: 300px;
                border-radius: 15px;
                margin: 20px auto;
            }

            #viewer{
                text-align: center;
            }

            #viewer>h2{
                
                height: 40px;

                margin-top: 20px;
                
                font-family: sans-serif;
                color: #aaaaaa;
            }


        </style>
    </head>
    <body>
        <div id="container">

        </div>
        <div id="viewer">
            <h2></h2>
            <div class="bar"><b></b></div>
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
                .attr("id", getId)
                //.attr('data-nom' ,getNom)
                .attr("class","bar")
                .on("click", showStation)
                .append("b")
                .style("height", pourcentPlace);

            // Exit…
            b.exit().remove();
        }

        var pourcentPlace = function(d) {
            var pourcent = (parseInt(d.places)/(parseInt(d.velos)+parseInt(d.places)))*100;
            console.log(pourcent, isNaN(pourcent));
            return isNaN(pourcent) ? "0%" : String(pourcent)+"%";
        };

        var teintePlace = function(d) {
            var pourcent =(parseInt(d.places)/(parseInt(d.velos)+parseInt(d.places)));
            pourcent = isNaN(pourcent) ? 0 : pourcent;
            var color = d3.hsl(pourcent*120,.6,.6);
            return color.toString();
        };

        var getId = function(d) {
            return d.id;
        }

        var getNom = function(d) {
            return d.nom;
        }

        var showStation = function(d){

            // 3 way to do the same thing:
            //
            //console.log(this.getAttribute("data-nom"));
            //console.log(d3.select(this).attr("data-nom"));
            //console.log(d.nom);

            d3.selectAll("#container>.bar").classed("active",false);
            d3.select(this).classed("active",true);

            d3.select("#viewer>.bar>b")
                .style({
                    'height': function(){ return pourcentPlace(d)},
                    "background-color":function(){ return teintePlace(d)}
                });
            d3.select("#viewer>h2").text(d.nom)
        }
    </script>
    </body>
</html>
