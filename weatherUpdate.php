<?php 
    include 'connDB.php';
    $weatherJsonData = json_decode(file_get_contents('https://opendata.cwb.gov.tw/api/v1/rest/datastore/F-C0032-001?Authorization=CWB-D57649E3-5209-4DC3-A64E-ABCCB0B5AB23'), true);
    //print_r($data);
    
    
    var_dump($weatherJsonData);
?>