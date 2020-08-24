<?php 
    include 'connDB.php';
    $token = "CWB-D57649E3-5209-4DC3-A64E-ABCCB0B5AB23";
    $weatherJsonData = json_decode(file_get_contents('https://opendata.cwb.gov.tw/api/v1/rest/datastore/F-C0032-001?Authorization='.$token), true);
    //print_r($data);
   try {
    // $locationName = $location['locationName'];
    // $stime = $location['weatherElement'][0]['time'][0]['startTime'];
    // $wx = $location['weatherElement'][0]['time'][0]['parameter']['parameterName'];
    // $PoP = $location['weatherElement'][1]['time'][0]['parameter']['parameterName'];
    // $MinT = $location['weatherElement'][2]['time'][0]['parameter']['parameterName'];
    // $MaxT = $location['weatherElement'][4]['time'][0]['parameter']['parameterName'];
    // $CI = $location['weatherElement'][3]['time'][0]['parameter']['parameterName'];
       //("$locationName","$stime","$wx","$MinT","$MaxT","$PoP","$CI")
       //var_dump($location);
        
       
        foreach($weatherJsonData['records']['location'] as $key => $item){
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
            // if($key==0)
            //     $sqlStatement.="(";
            $sqlStatement.= '("'.$locationName.'","'.$stime.'","'.$wx.'","'.$MinT.'","'.$MaxT.'","'.$PoP.'","'.$CI.'");';
            $result = $conn->query($sqlStatement);
            // if($key==count($weatherJsonData['records']['location']))
            //     $sqlStatement.=");";            
        }
        echo "<br>".$sqlStatement."<br>";
        //$sqlStatement = substr($sqlStatement,0,strlen($sqlStatement)-1);
        // $result = $conn->query($sqlStatement);
        //$conn->exec($sqlStatement);
   } catch (PDOException $e) {
        echo $sqlStatement . "<br>" . $e->getMessage();
   }
    $conn=null;
   echo ("<br>".count($weatherJsonData['records']['location'])."<br>");
    var_dump($weatherJsonData);
    
?>
