<?php



function insertToday(){
    try {
        include 'connDB.php';
        $token = "CWB-D57649E3-5209-4DC3-A64E-ABCCB0B5AB23";
        $toDayJsonData = json_decode(file_get_contents('https://opendata.cwb.gov.tw/api/v1/rest/datastore/F-C0032-001?Authorization=' . $token), true);
        foreach ($toDayJsonData['records']['location'] as $key => $item) {
            $sqlStatement = <<<multi
            insert into today (locationName,stime,Wx,minT,maxT,POP,CI) 
            values
            multi;
            $locationName = $item['locationName'];
            $stime = $item['weatherElement'][0]['time'][0]['startTime'];
            $wx = $item['weatherElement'][0]['time'][0]['parameter']['parameterName'];
            $PoP = $item['weatherElement'][1]['time'][0]['parameter']['parameterName'];
            $MinT = $item['weatherElement'][2]['time'][0]['parameter']['parameterName'];
            $MaxT = $item['weatherElement'][4]['time'][0]['parameter']['parameterName'];
            $CI = $item['weatherElement'][3]['time'][0]['parameter']['parameterName'];

            $sqlStatement .= '("' . $locationName . '","' . $stime . '","' . $wx . '","' . $MinT . '","' . $MaxT . '","' . $PoP . '","' . $CI . '");';
            $result = $conn->query($sqlStatement);
        }
        echo "<br>" . $sqlStatement . "<br>";
        //$sqlStatement = substr($sqlStatement,0,strlen($sqlStatement)-1);
        //$result = $conn->query($sqlStatement);
        //$conn->exec($sqlStatement);
    } catch (PDOException $e) {
        echo $sqlStatement . "<br>" . $e->getMessage();
    }
    $conn = null;
}
function insertWeek(){
    try {
        include 'connDB.php';
        $token = "CWB-D57649E3-5209-4DC3-A64E-ABCCB0B5AB23";
        $weekJsonData  = json_decode(file_get_contents('https://opendata.cwb.gov.tw/api/v1/rest/datastore/F-D0047-091?Authorization=' . $token . '&elementName=WeatherDescription'), true);


        $cnt = count($weekJsonData['records']['locations'][0]['location']);
       
        //stime2,Wx2,minT2,maxT2,POP2,CI2,stime3,Wx3,minT3,maxT3,POP3,CI3
        for ($i = 0; $i < $cnt; $i++) {
            $location = $weekJsonData['records']['locations'][0]['location'][$i];
            $locationName = $location['locationName'];
            //echo $locationName;
            $sqlStatement = <<<multi
            insert into week (id,locationName,stime,Wx,minT,maxT,POP,CI) 
            values
            multi;


            //$stime[] = $location['weatherElement'][0]['time'][0]['startTime'];
            //$stime2 = $location['weatherElement'][0]['time'][1]['startTime'];
            //$stime3 = $location['weatherElement'][0]['time'][2]['startTime'];
            for ($j = 0; $j < 14; $j++) {
                $id = $j+($i*14);
                $elementValue = $location['weatherElement'][0]['time'][$j]['elementValue'][0]['value'];
                $elementStrlen = mb_split("。", $elementValue);
                if (strpos($elementStrlen[1],'降雨機率') === false){                    
                    $elementStrlen[3]=$elementStrlen[2];
                    $elementStrlen[2]=$elementStrlen[1];                    
                    $elementStrlen[1]="降雨機率 0%";                   
                }
                //var_dump($elementStrlen);
                $stime[] = $location['weatherElement'][0]['time'][$j]['startTime'];
                $Wx[]    = $elementStrlen[0];
                $POP[]  = $elementStrlen[1];
                $minT[]  = mb_substr($elementStrlen[2], 4, 2, "UTF-8");
                $maxT[] = mb_substr($elementStrlen[2], 7, 2, "UTF-8");
                $CI[]    = $elementStrlen[3];                
                $sqlStatement.="('$id','$locationName','{$stime[$j]}','{$Wx[$j]}','{$minT[$j]}','{$maxT[$j]}','{$POP[$j]}','{$CI[$j]}'),";                        
            }
            $sqlStatement = substr($sqlStatement,0,-1);
            $sqlStatement.="ON DUPLICATE KEY UPDATE stime=VALUES(stime),Wx=VALUES(Wx),minT=VALUES(minT),maxT=VALUES(maxT),POP=VALUES(POP),CI=VALUES(CI);";
            //echo $sqlStatement;
            $result = $conn->query($sqlStatement);
            //mysql_query("select * from `sql_tab` where `name`='{$_POST["name"]}'");
            //stime2,Wx2,minT2,maxT2,POP2,CI2,stime3,Wx3,minT3,maxT3,POP3,CI3
            $Wx = $POP = $minT = $maxT = $CI = array();
        }

        // foreach ($weekJsonData['records']['locations'] as $key => $item) {
        //     $sqlStatement = <<<multi
        //     insert into today (locationName,stime,Wx,minT,maxT,POP,CI) 
        //     values
        //     multi;
        // }
    } catch (\Throwable $th) {
        throw $th;
    }
    $conn = null;
}

function insertObsRain(){
    try {
        include 'connDB.php';
        $token = "CWB-D57649E3-5209-4DC3-A64E-ABCCB0B5AB23";
        $obsRainJdata  = json_decode(file_get_contents('https://opendata.cwb.gov.tw/api/v1/rest/datastore/O-A0002-001?Authorization='.$token.'&elementName=RAIN&elementName=HOUR_24&parameterName=CITY'), true);
        //var_dump($obsRainJdata);

        $cnt = count($obsRainJdata['records']['location']);
        $sqlStatement = <<<multi
            insert into obsrain (id,locationName,obsStationName,obsTime,HOUR_24,RAIN) 
            values 
            multi;
        //var_dump($obsRainJdata['records']['location']);
        //echo $cnt;
        for ($i = 0; $i < $cnt; $i++) {
            
            $location       = $obsRainJdata['records']['location'][$i];
            $id             = $location['stationId'];
            $obsStationName = $location['locationName'];
            $locationName   = $location['parameter'][0]['parameterValue'];
            $obsTime        = $location['time']['obsTime'];
            $HOUR_24        = $location['weatherElement'][1]['elementValue'];
            $RAIN           = $location['weatherElement'][0]['elementValue'];

            ($HOUR_24<0)?$HOUR_24="0.00":$HOUR_24=$HOUR_24;
            ($RAIN<0)?$RAIN="0.00":$RAIN=$RAIN;       

            $sqlStatement .="('$id','$locationName','$obsStationName','$obsTime','$HOUR_24','$RAIN'),";            
        }
        $sqlStatement = substr($sqlStatement,0,-1);
        $sqlStatement.="ON DUPLICATE KEY UPDATE obsTime=VALUES(obsTime),HOUR_24=VALUES(HOUR_24),RAIN=VALUES(RAIN);";
        //echo $sqlStatement;
        try {
            $result = $conn->query($sqlStatement);
        } catch (\Throwable $th) {
            echo $th;
        }
       
        
    } catch (\Throwable $th) {
        throw $th;
    }
}
//insertToday();
insertWeek();
insertObsRain();

