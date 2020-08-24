<?php
session_start();
include_once 'connDB.php';

    if(isset($_GET['locationName'])){
        try {
            $city = $_GET['locationName'];
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sqlStatement = <<<multi
            SELECT * FROM today WHERE locationName = "$city"
            multi;
            $stmt = $conn->prepare($sqlStatement);
            $stmt->execute();
            var_dump($stmt);
            $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $result =$stmt->fetch();
            $locationName=$result['locationName'];
            $stime=$result['stime'];
            $Wx=$result['Wx'];
            $minT=$result['minT'];
            $maxT=$result['maxT'];
            $POP=$result['POP'];
            $CI=$result['CI']; 

            //
            echo $result['locationName'];
            // foreach($stmt->fetch() as $key =>$item){
            //     if($key==="id")
            //      continue;
            //     echo $item;
            // }
            
            header("Location: index.php");
        } catch (\Throwable $th) {
            //throw $th;
        }
        
        
        
    }
   
    // echo '<div id ="card1"class="card" style="width: 18rem;">';                        
    // echo '  <div class="card-body">';
    // echo '  <h3 class="card-title">'.$result.'</h5>';
    // echo '  <h4 id = "Wx"class="card-title">Card title</h5>';
    // echo'<h4 id = "T" class="card-title">Card title</h5>';
    // echo '<h4 id = "POP" class="card-title">Card title</h5>';
    // echo '<h4 id = "CI" class="card-title">Card title</h5>';
    // echo '<!-- <a href="#" class="btn btn-primary">Go somewhere</a> -->';
    // echo'</div>';
    // echo'<img class="card-img-top" src="..." alt="Card image cap">';
    // echo '</div>';
?>