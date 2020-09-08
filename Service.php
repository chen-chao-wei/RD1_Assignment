<?php 
include 'connDB.php';

header('Content-Type: application/json; charset=UTF-8'); //設定資料類型為 json，編碼 utf-8
if ($_SERVER['REQUEST_METHOD'] == "GET") { //如果是 POST 請求    
    
    $sqlStatement = <<<multi
        SELECT locationName ,sum(HOUR_24)FROM `obsrain` as HOUR_24
        GROUP by locationName
    multi;
    $result = $conn->query($sqlStatement);
    $result = $result->fetchAll();
    $data=[];
    $text=null;
    foreach($result as $key=>$item){
        //$text.="$item[0] => $item[1]"; 
        array_push($data,array($item[0] => $item[1])); 
    }
    if ($data) {        
        echo json_encode(array(
            'HOUR_24' => $data
        ));
    } else {
        echo json_encode(array(
            'errorMsg' => "查詢失敗,ERROR CODE:2"
        ));
    }
    //系統初始化
}
