<?php


include_once 'connDB.php';


// $sqlStatement = <<<multi
// select employeeId,firstName,lastName,e.cityId,cityName
//     from city c join employee e on e.cityId = c.cityId;
// multi;
// $result = $conn->query($sqlStatement);
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>welcome</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/jquery.toast.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">


</head>

<body>


    <div class="container d-flex justify-content-center">
        <svg width="800px" height="600px" viewBox="0 0 800 600"></svg>
    </div>
    <script src="js/jquery.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script type="text/javascript" src="js/jquery.toast.js"></script>

    <script src="http://d3js.org/d3.v3.min.js" charset="utf-8"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/d3/3.5.17/d3.min.js" charset="utf-8"></script>
    <script src="https://unpkg.com/topojson@3"></script>
    <script type="text/javascript" src="http://d3js.org/topojson.v1.min.js"></script>
    <script>
        $(document).ready(function() {

            $.get("DBinit.php");
                setTimeout(function() {
                    location.href = 'http://localhost:8888/RD1_Assignment/county.php';
                }, 3000);
                      
            window.addEventListener("click", function(event) {
                location.href = 'http://localhost:8888/RD1_Assignment/county.php';
            });
            var HOUR_24Data;
            $.get('Service.php', function(data) {
                HOUR_24Data = data.HOUR_24;
                console.log(HOUR_24Data);
                d3.json("./data/taiwan2.json", function(topodata) {
                    var features = topojson.feature(topodata, topodata.objects["COUNTY_MOI_1090727"]).features;
                    //console.log(features);
                    for (i = features.length - 1; i >= 0; i--) {
                        for (j = HOUR_24Data.length - 1; j >= 0; j--) {
                            if (HOUR_24Data[j][features[i].properties.COUNTYNAME] != undefined)
                                features[i].properties.density = HOUR_24Data[j][features[i].properties.COUNTYNAME];
                        }
                        //features[i].properties.density = i;
                        //features[i].properties.density = HOUR_24Data[features[i].properties.COUNTYNAME];
                        //console.log(features[i].properties.COUNTYNAME);
                    }
                    var path = d3.geo.path().projection(
                        d3.geo.mercator().center([121, 24]).scale(6000) // 座標變換函式
                    );
                    var color = d3.scale.linear().domain([0, 100]).range(["#e9ecef", "#1870c7"]);

                    d3.select("svg").selectAll("path").data(features)
                        .enter().append("path").attr("d", path).style("fill", function(d) {
                            return color(d.properties.density);
                        });
                });
            })

        });
    </script>
</body>

</html>