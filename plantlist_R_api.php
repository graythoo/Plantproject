<?php
    $servername = "127.0.0.1";
    $username = "owner";
    $password = "Pt//12345678";
    $dbname = "plantdb";

    $conn = mysqli_connect($servername,$username,$password,$dbname);

    $sql = "SELECT * FROM plantlist ORDER BY Username DESC";
   
   mysqli_query($conn ,'SET NAMES utf8');
   $result = mysqli_query($conn,$sql);    
   
    if(mysqli_num_rows($result) > 0){
        $mydata =array();
        while($row = mysqli_fetch_assoc($result)){
            $mydata[]=$row; 
        }
            echo '{"state":true,"message":"讀取資料成功","data":'.json_encode($mydata).'}';
        }else{
             echo '{"state":false,"message":"讀取資料失敗或查無資料"}';
        }

    mysqli_close($conn);
?>