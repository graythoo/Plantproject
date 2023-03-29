<?php

    $data=file_get_contents("php://input","r");
    $mydata=array();
    $mydata=json_decode($data,true);

    if(isset($mydata["id"]) && isset($mydata["role"])){
        if(($mydata["id"]) != "" && ($mydata["role"]) != ""){

            $p_id = $mydata["id"];
            $p_role = $mydata["role"];
            
            require_once("plantdbtools.php");
            $link = create_connect();

            $sql="UPDATE member SET Role ='$p_role' WHERE ID = '$p_id'";
            
            if(execute_sql($link,"plantdb",$sql)){
                echo '{"state":true,"message":"更新資料成功!"}';
            }else{
                echo '{"state":false,"message":"更新資料失敗!'.$sql.mysqli_error($link).'"}'; 
            }
            mysqli_close($link);
        }else{
            echo '{"state":false,"message":"欄位不得為空白"}'; 
        }
    }else{
        echo '{"state":false,"message":"缺少規定欄位"}'; 
    }
?>