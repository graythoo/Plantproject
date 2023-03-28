<?php

    $data = file_get_contents("php://input","r");
    $jsonData = array();
    $jsonData = json_decode($data,true);

    if(isset ($jsonData["ID"]) && isset ($jsonData["username"])){
        if($jsonData["ID"] != "" && $jsonData["username"] != ""){

            $p_id = $jsonData["ID"];
            $p_username = $jsonData["username"];

            $servername = "127.0.0.1";
            $username = "owner";
            $password = "Pt//12345678";
            $dbname = "plantdb";

            $conn = mysqli_connect($servername,$username,$password,$dbname);

            if(!$conn){
                die("連線失敗!".mysqli_connect_error());
            }
            
            mysqli_query($conn ,'SET NAMES utf8;');

            $sql = "SELECT * FROM plantlist WHERE ID='$p_id' AND Username = '$p_username'";
            
            $result = mysqli_query($conn,$sql);
            if(mysqli_num_rows($result) == 1){
                $mydata =array();
                while($row = mysqli_fetch_assoc($result)){
                    $mydata[] = $row;
                }
                echo '{"state": true, "message":"讀取資料成功!", "data":'. json_encode($mydata).'}';
            
            }else{
                echo '{"state": false, "message":"讀取資料失敗!錯誤代碼或相關訊息"}' . mysqli_error($conn) . '"}';
            }
            mysqli_close($conn);            
        }else{
            echo '{"state": false, "message":"欄位不得為空白!"}';
        }
    }else{
        echo '{"state": false, "message":"缺少規定欄位!"}';
    }
?>