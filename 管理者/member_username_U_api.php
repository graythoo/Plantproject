<?php

    $data=file_get_contents("php://input","r");
    $mydata=array();
    $mydata=json_decode($data,true);

    if(isset($mydata["id"]) && isset($mydata["username"]) && isset($mydata["newusername"])){
        if(($mydata["id"]) != "" && $mydata["username"] != "" && $mydata["newusername"] != ""){

            $p_id = $mydata["id"];
            $p_username = $mydata["username"];
            $p_newusername = $mydata["newusername"];
            
            require_once("plantdbtools.php");
            $link = create_connect();

            $sql01="UPDATE member SET Username ='$p_newusername' WHERE ID = '$p_id'";
            $sql02="UPDATE image SET Username ='$p_newusername' WHERE Username ='$p_username'";
            $sql03="UPDATE c_plant SET Username ='$p_newusername' WHERE Username ='$p_username'";

            $result01 = execute_sql($link,"plantdb",$sql01);
            $result02 = execute_sql($link,"plantdb",$sql02);
            $result03 = execute_sql($link,"plantdb",$sql03);

            if($result01 && $result02 && $result03){
                echo '{"state":true,"message":"更新資料成功!"}';
            }else{
                echo '{"state":false,"message":"更新資料失敗!"}'; 
            }
            mysqli_close($link);
        }else{
            echo '{"state":false,"message":"欄位不得為空白"}'; 
        }
    }else{
        echo '{"state":false,"message":"缺少規定欄位"}'; 
    }
?>