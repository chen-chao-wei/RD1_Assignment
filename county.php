<?php


include_once 'connDB.php';


if (isset($_GET['locationName'])) {
    $city = $_GET['locationName'];
} else {
    $city = "臺北市";
}
if (isset($_GET['flag'])) {
    $tableCount = $_GET['flag'];
} else {
    $tableCount = 7;
}
try {
    //----SELECT TODAY TABLE START----//
    //echo $_GET['locationName'];

    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sqlStatement = <<<multi
    SELECT * FROM today WHERE locationName = "$city"
    multi;

    $stmt = $conn->prepare($sqlStatement);
    $stmt->execute();
    //var_dump($stmt);
    global $result;
    $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $result = $stmt->fetch();
    $locationName = $result['locationName'];
    $stime = $result['stime'];
    $Wx = $result['Wx'];
    $minT = $result['minT'];
    $maxT = $result['maxT'];
    $POP = $result['POP'];
    $CI = $result['CI'];
    //----SELECT TODAY TABLE END----//
} catch (\Throwable $th) {
    throw "SELECT TODAY TABLE ERROR" . $th;
}
try {
    //----SELECT WEEK TABLE START----//
    class CWeatherDescription
    {
        var $locationName = array();
        var $stime = array();
        var $Wx = array();
        var $POP = array();
        var $minT = array();
        var $maxT = array();
        var $CI = array();
    }
    $sqlStatement = <<<multi
    SELECT * FROM week WHERE locationName = "$city"
    multi;
    //echo $sqlStatement;
    $stmt = $conn->prepare($sqlStatement);
    $stmt->execute();
    $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $result = $stmt->fetchAll();
    //var_dump($result[1]);
    $week = new CWeatherDescription();

    foreach ($result as $key => $item) {
        $week->locationName[] = $item['locationName'];
        $week->stime[] = $item['stime'];
        $week->Wx[] = $item['Wx'];
        $week->POP[] = $item['POP'];
        $week->minT[] = $item['minT'];
        $week->maxT[] = $item['maxT'];
        $week->CI[] = $item['CI'];
        //echo "#".$key."@".$item['stime']."<br>";
    }
    //----SELECT WEEK TABLE END----//
} catch (\Throwable $th) {
    throw "SELECT WEEK TABLE ERROR" . $th;
}
try {
    //----SELECT OBSRAIN TABLE START----//
    $sqlStatement = <<<multi
    SELECT locationName, SUM(HOUR_24)as HOUR_24,SUM(NOW)as NOW 
    FROM obsrain 
    GROUP BY `obsrain`.`locationName`
    ORDER BY `obsrain`.`locationName` DESC
    multi;
    //echo $sqlStatement;
    $stmt = $conn->prepare($sqlStatement);
    $stmt->execute();
    $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $result = $stmt->fetchAll();
    //var_dump($result);
    class CObsData
    {
        var $locationName=array();
        var $NOW=array();
        var $HOUR_24=array();
    }
    $obsStation = new CObsData;
    //var_dump($result);
    foreach ($result as $key => $item) {
        $obsStation->locationName[] = $item['locationName'];
        $obsStation->NOW[] = $item['NOW'];
        $obsStation->HOUR_24[] = $item['HOUR_24'];
    }
    //echo $obsStation->locationName[2]."+".$obsStation->NOW[2] . "+" . $obsStation->HOUR_24[2];
    //----SELECT OBSRAIN TABLE END----//
    //header("Location: index.php");
} catch (\Throwable $th) {
    throw "SELECT OBSRAIN TABLE ERROR" . $th;
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Lab</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/jquery.toast.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">

</head>

<body class="body-color">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">


    <div class="container">

        <div class="row">
            <div class="col-sm-2">
                &nbsp;
            </div>
            <div class="col-sm-8">
                <span></span>
                <form name="weatherForm" action="county.php?locationName=">
                    <div class="form-group row">
                        <label for="select" class="h1 col-5 ">選擇縣市:<?= $city ?></label>
                        <div class="h3 col-8">
                            <select id="myCID" name="locationName">
                                <option value="" disabled="" selected="">選擇縣市</option>
                                <option value="overall">總覽</option>
                                <option value="基隆市">基隆市</option>
                                <option value="臺北市">臺北市</option>
                                <option value="新北市">新北市</option>
                                <option value="桃園市">桃園市</option>
                                <option value="新竹市">新竹市</option>
                                <option value="新竹縣">新竹縣</option>
                                <option value="苗栗縣">苗栗縣</option>
                                <option value="臺中市">臺中市</option>
                                <option value="彰化縣">彰化縣</option>
                                <option value="南投縣">南投縣</option>
                                <option value="雲林縣">雲林縣</option>
                                <option value="嘉義市">嘉義市</option>
                                <option value="嘉義縣">嘉義縣</option>
                                <option value="臺南市">臺南市</option>
                                <option value="高雄市">高雄市</option>
                                <option value="屏東縣">屏東縣</option>
                                <option value="宜蘭縣">宜蘭縣</option>
                                <option value="花蓮縣">花蓮縣</option>
                                <option value="臺東縣">臺東縣</option>
                                <option value="澎湖縣">澎湖縣</option>
                                <option value="金門縣">金門縣</option>
                                <option value="連江縣">連江縣</option>
                            </select>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>

                    </div>


                </form>

                <div id="showCard" class="row">
                    <?php for ($i = 0; $i < 3; $i++) { ?>
                        <div id="card1" class="col card card-margins" style="width: 18rem;">
                            <div class="card-body">
                                <h3 class="card-title"><?= $week->stime[$i] ?></h5>
                                    <h4 id="Wx" class="card-title"><?= $week->Wx[$i] ?></h5>
                                        <h4 id="T" class="card-title"><?= "溫度攝氏" . $week->minT[$i] . "~" . $week->maxT[$i] . "°C" ?></h5>
                                            <h4 id="POP" class="card-title"><?= "降雨機率:" . $week->POP[$i] ?></h5>
                                                <h4 id="CI" class="card-title"><?= "舒適度:" . $week->CI[$i] ?></h5>
                                                    <!-- <a href="#" class="btn btn-primary">Go somewhere</a> -->
                            </div>
                            <img class="card-img-top" <?= 'src="images/p' . $i . '.png"' ?> alt="Card image cap">
                            <span>&nbsp;</span>
                        </div>
                    <?php } ?>

                </div>
                <div>
                    &nbsp;
                </div>
                <div>
                    <table class=" table table-striped">
                        <thead id="weekDate">
                            <tr>
                                <h1>天氣預報</h1>
                                <span><a href="county.php?locationName=<?php echo $city ?>&flag=3" class="btn-margins btn btn-info">
                                        <h3>今明兩天</h3>
                                    </a></span>
                                <span><a href="county.php?locationName=<?php echo $city ?>&flag=7" class="btn-margins btn btn-info">
                                        <h3>未來一週</h3>
                                    </a></span>
                            </tr>

                            <tr>
                                <?php
                                for ($i = 0; $i < $tableCount; $i++) {
                                    echo '<th scope="col">' . $week->stime[$i] . '</th>';
                                }
                                ?>
                            </tr>
                        </thead>
                        <tbody>


                            <?php echo '<tr>';
                            for ($i = 0; $i < $tableCount; $i++) {
                                echo '<th scope="col">' . $week->Wx[$i] . '</th>';
                            }
                            echo '</tr>';
                            echo '<tr>';
                            for ($i = 0; $i < $tableCount; $i++) {
                                echo '<th scope="col">' . $week->POP[$i] . '</th>';
                            }
                            echo '</tr>';
                            echo '<tr>';
                            for ($i = 0; $i < $tableCount; $i++) {
                                echo '<th scope="col">' . '溫度攝氏' . $week->minT[$i] . "~" . $week->maxT[$i] . '°C</th>';
                            }
                            echo '</tr>';
                            echo '<tr>';
                            for ($i = 0; $i < $tableCount; $i++) {
                                echo '<th scope="col">' . $week->CI[$i] . '</th>';
                            }
                            echo '</tr>' ?>
                        </tbody>
                    </table>
                    <div>
                        <h1>全台雨量觀測</h1>
                        <span><a href="county.php?locationName=<?php echo $city."&flag=".$tableCount?>" class="btn-margins btn btn-info">
                                <h3>今明兩天</h3>
                            </a></span>
                            <span><a href="county.php?locationName=<?php echo $city."&flag=".$tableCount?>" class="btn-margins btn btn-info">
                                <h3>未來一週</h3>
                            </a></span>
                        <svg width="800px" height="600px" viewBox="0 0 800 600"></svg>

                    </div> <!-- end of row -->

                </div> <!-- end of container -->
                <div class="col-sm-2">
                    &nbsp;

                </div>
                <!-- https://opendata.cwb.gov.tw/api/v1/rest/datastore/F-C0032-001?Authorization=CWB-D57649E3-5209-4DC3-A64E-ABCCB0B5AB23 -->
                <script src="js/jquery.js"></script>
                <script src="js/bootstrap.min.js"></script>
                <script type="text/javascript" src="js/jquery.toast.js"></script>
                <svg width="800px" height="600px" viewBox="0 0 800 600"></svg>
                <script src="http://d3js.org/d3.v3.min.js" charset="utf-8"></script>
                <script src="https://cdnjs.cloudflare.com/ajax/libs/d3/3.5.17/d3.min.js" charset="utf-8"></script>
                <script src="https://unpkg.com/topojson@3"></script>
                <script type="text/javascript" src="http://d3js.org/topojson.v1.min.js"></script>
                <script>
                    d3.json("./data/taiwan2.json", function(topodata) {
                        var features = topojson.feature(topodata, topodata.objects["COUNTY_MOI_1090727"]).features;

                        var path = d3.geo.path().projection(
                            d3.geo.mercator().center([121, 24]).scale(6000) // 座標變換函式
                        );
                        for (i = features.length - 1; i >= 0; i--) {
                           
                            features[i].properties.density = i;
                            console.log(features[i].properties.density);
                        }
                        var color = d3.scale.linear().domain([0, 100]).range(["#e9ecef", "#1870c7"]);

                        d3.select("svg").selectAll("path").data(features)
                            .enter().append("path").attr("d", path).style("fill", function(d) {
                                return color(d.properties.density);
                            });


                    });
                </script>
                <script type="text/javascript">
                    $(document).ready(function() {

                    });
                    document.getElementById("myCID").onchange = function() {
                        var city = $("#myCID option:selected").text();
                        $("#description").empty();
                        console.log(city);
                        //getWeather(city);
                    };
                </script>
</body>

</html>