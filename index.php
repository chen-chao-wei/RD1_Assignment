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
    <title>Lab</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/jquery.toast.css">


</head>

<body>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">


    <div class="container">

        <div class="row">
            <div class="col-sm-2">
                &nbsp;
            </div>
            <div class="col-sm-8">
                <form name="weatherForm" action="getWeather.php?locationName=">>
                    <div class="form-group row">
                        <label for="select" class="h1 col-5 ">選擇縣市</label>
                        <div class="h3 col-8">
                            <select id="myCID" name="locationName">
                                <option value="" disabled="" selected="">選擇縣市</option>
                                <option value="overall">總覽</option>
                                <option value="基隆市">基隆市</option>
                                <option value="臺北市" selected>臺北市</option>
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

                        </div>
                    </div>
                    
                    <div class="form-group row">
                        <div class="offset-4 col-8">                            
                            
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </div>
                </form>
                <div id="showCard" class="row">
                    <div id="card1" class="card" style="width: 18rem;">
                        <div class="card-body">
                            <h3 class="card-title">Card title</h5>
                                <h4 id="Wx" class="card-title"><?= $Wx ?></h5>
                                    <h4 id="T" class="card-title">Card title</h5>
                                        <h4 id="POP" class="card-title">Card title</h5>
                                            <h4 id="CI" class="card-title">Card title</h5>
                                                <!-- <a href="#" class="btn btn-primary">Go somewhere</a> -->
                        </div>
                        <img class="card-img-top" src="..." alt="Card image cap">
                    </div>
                    <div id="card2" class="card" style="width: 18rem;">
                        <div class="card-body">
                            <h3 class="card-title">Card title</h5>
                                <h4 id="Wx" class="card-title">Card title</h5>
                                    <h4 id="T" class="card-title">Card title</h5>
                                        <h4 id="POP" class="card-title">Card title</h5>
                                            <h4 id="CI" class="card-title">Card title</h5>
                                                <!-- <a href="#" class="btn btn-primary">Go somewhere</a> -->
                        </div>
                        <img class="card-img-top" src="..." alt="Card image cap">
                    </div>
                    <div id="card3" class="card" style="width: 18rem;">
                        <div class="card-body">
                            <h3 class="card-title">Card title</h5>
                                <h4 id="Wx" class="card-title">Card title</h5>
                                    <h4 id="T" class="card-title">Card title</h5>
                                        <h4 id="POP" class="card-title">Card title</h5>
                                            <h4 id="CI" class="card-title">Card title</h5>
                                                <!-- <a href="#" class="btn btn-primary">Go somewhere</a> -->
                        </div>
                        <img class="card-img-top" src="..." alt="Card image cap">
                    </div>
                </div>

                <div>
                    <table class=" table table-striped">
                        <thead id="weekDate">
                            <tr>
                                <h1>一週天氣</h1>
                                <a href="addEmployee.php" class="btn btn-outline-info">New</a>
                            </tr>
                            <tr>
                                <th scope="col">1</th>
                                <th scope="col">2</th>
                                <th scope="col">3</th>
                                <th scope="col">4</th>
                                <th scope="col">5</th>
                                <th scope="col">6</th>
                                <th scope="col">7</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr id="description">

                            </tr>

                        </tbody>
                    </table>
                    <div>
                        <div class="col-sm-2">
                            &nbsp;
                            <button id="btn">click</button>
                            
                        </div>

                    </div> <!-- end of row -->

                </div> <!-- end of container -->

                <!-- https://opendata.cwb.gov.tw/api/v1/rest/datastore/F-C0032-001?Authorization=CWB-D57649E3-5209-4DC3-A64E-ABCCB0B5AB23 -->
                <script src="js/jquery.js"></script>
                <script src="js/bootstrap.min.js"></script>
                <script type="text/javascript" src="js/jquery.toast.js"></script>
                <script type="text/javascript">
                    $(document).ready(function() {
                        //getWeather("臺北市");

                        $.post('getWeather.php', {
                            locationName: '臺北市'
                        });

                        // $.ajax({url: "你的更新API連結", success: function(result){
                        //         $("要更新的DOM").html("想要顯示的內容");
                        //     }
                        // });
                    });
                    var btn = document.getElementById("btn");
                    btn.addEventListener('click', function() {
                        $.ajax({
                            type: 'POST',
                            url: 'getWeather.php',
                            data: '臺北市',
                            dataType: "text",
                            success: function(resultData) {
                                //alert("OK")
                                console.log(resultData);
                                
                            },
                            error: function(e){
                                alert(e);
                            }
                        });
                        
                        $.get('getWeather.php', function(data){
                            alert(data);
                        });
                    }, false)
                    document.getElementById("myCID").onchange = function() {
                        var city = $("#myCID option:selected").text();
                        $("#description").empty();
                        console.log(city);
                        //getWeather(city);
                    };

                    function getWeather(city) {
                        //get 36h weather
                        $.ajax({
                            url: "https://opendata.cwb.gov.tw/api/v1/rest/datastore/F-C0032-001?Authorization=CWB-D57649E3-5209-4DC3-A64E-ABCCB0B5AB23&locationName=" + encodeURI(city),
                            type: "GET",
                            dataType: "json",
                            success: function(Jdata) {
                                let day = [];
                                let night = [];
                                let tomorrow = [];
                                for (let i = 0; i < 5; i++) {
                                    day.push(Jdata.records.location[0].weatherElement[i].time[0].parameter.parameterName);
                                    night.push(Jdata.records.location[0].weatherElement[i].time[1].parameter.parameterName);
                                    tomorrow.push(Jdata.records.location[0].weatherElement[i].time[2].parameter.parameterName);
                                }

                                //console.log(day[0] ,day[1] ,day[2] ,day[3] ,day[4]);

                                //0=>天氣狀況 1=>降雨機率 2=>最低溫 3=>氣溫描述 4=> 最高溫                            
                                let cityName = Jdata.records.location[0].locationName;
                                let toDay;
                                let toNight = Jdata.records.location[0].weatherElement[0].time[1].parameter.parameterName;
                                var toTomorrow = Jdata.records.location[0].weatherElement[0].time[2].parameter.parameterName;
                                console.log(cityName);
                                console.log(toDay);
                                //TODO forloop showCard
                                // for(let i =0;i<3;i++){
                                //     $("#showCard").append('<div class="card" style="width: 18rem;">');
                                //     $('#showCard class="card"').append('<div class="card-body">');
                                //     $('#showCard class="card-body"').append('<h3 class="card-title">1</h3>');
                                //     $("#showCard").append('<h4 id = "Wx" class="card-title">2</h4>');
                                //     $("#showCard").append('<h4 id = "T" class="card-title">3</h4>');
                                //     $("#showCard").append('<h4 id = "POP" class="card-title">4</h4>');
                                //     $("#showCard").append('<h4 id = "CI" class="card-title">5</h4>');
                                //     $("#showCard").append('</div>');
                                //     $("#showCard").append('<img class="card-img-top" src="..." alt="Card image cap">');
                                //     $("#showCard").append('</div>');                        
                                // };
                                $('#card1 h3').text("今晚明晨");
                                $("#card1 #Wx").text(day[0]);
                                $("#card1 #T").text("攝氏溫度" + day[2] + "~" + day[4] + "°C");
                                $("#card1 #POP").text("降雨機率 " + day[1] + "%");
                                $("#card1 #CI").text(day[3]);
                                $('#card2 h3').text("明日白天");
                                $("#card2 #Wx").text(night[0]);
                                $("#card2 #T").text("攝氏溫度" + night[2] + "~" + night[4] + "°C");
                                $("#card2 #POP").text("降雨機率 " + night[1] + "%");
                                $("#card2 #CI").text(night[3]);
                                $('#card3 h3').text("今日白天");
                                $("#card3 #Wx").text(tomorrow[0]);
                                $("#card3 #T").text("攝氏溫度" + tomorrow[2] + "~" + tomorrow[4] + "°C");
                                $("#card3 #POP").text("降雨機率 " + tomorrow[1] + "%");
                                $("#card3 #CI").text(tomorrow[3]);
                            },
                            error: function() {
                                alert("ERROR!!!");
                            }
                        });
                        //get week weather
                        $.ajax({
                            url: "https://opendata.cwb.gov.tw/api/v1/rest/datastore/F-D0047-091?Authorization=CWB-D57649E3-5209-4DC3-A64E-ABCCB0B5AB23&locationName=" + encodeURI(city) + "&elementName=WeatherDescription",
                            type: "GET",
                            dataType: "json",
                            success: function(Jdata) {
                                let weekDayDescription = [];
                                let weekNightDescription = [];
                                let date = [];
                                let count = 0;
                                for (let i = 0; i < 7; i++) {
                                    count++;
                                    weekDayDescription.push(Jdata.records.locations[0].location[0].weatherElement[0].time[i + i].elementValue[0].value);
                                    weekNightDescription.push(Jdata.records.locations[0].location[0].weatherElement[0].time[i + count].elementValue[0].value);
                                    //weekDayDescription[i] = weekDayDescription[i].substring(weekDayDescription[i].indexOf('偏'));
                                    weekDayDescription[i] = weekDayDescription[i].replace(/。/g, "<br>");
                                    weekNightDescription[i] = weekNightDescription[i].replace(/。/g, "<br>");
                                    console.log(i + i, i + count);
                                }
                                for (let i = 0; i < 7; i++) {
                                    $("#description").append('<td>' + weekDayDescription[i] + '</td>');
                                }

                            },
                            error: function() {
                                alert("ERROR!!!");
                            }
                        });
                    }
                </script>
</body>

</html>