<?php

    $data=file_get_contents("php://input","r");
    $mydata=array();
    $mydata=json_decode($data,true);

    if(isset($mydata["id"]) && isset($mydata["gender"]) && isset($mydata["city"]) && isset($mydata["tel"]) && isset($mydata["email"])){
        if(($mydata["id"]) != "" && ($mydata["gender"]) != "" && ($mydata["city"]) != "" && ($mydata["tel"]) != "" && ($mydata["email"]) != ""){

            $p_id = $mydata["id"];
            $p_gender=$mydata["gender"];
            $p_city=$mydata["city"];
            $p_tel=$mydata["tel"];
            $p_email = $mydata["email"];
            
            require_once("plantdbtools.php");
            $link = create_connect();

            $sql="UPDATE user SET Gender= '$p_gender',City= '$p_city',Tel='$p_tel',Email= '$p_email' WHERE ID = '$p_id'";
            
            if(execute_sql($link,"plantdb",$sql)){
                echo '{"state":true,"message":"更新會員成功!"}';
            }else{
                echo '{"state":false,"message":"更新會員失敗!'.$sql.mysqli_error($link).'"}'; 
            }
            mysqli_close($link);
        }else{
            echo '{"state":false,"message":"欄位不得為空白"}'; 
        }
    }else{
        echo '{"state":false,"message":"缺少規定欄位"}'; 
    }
?>