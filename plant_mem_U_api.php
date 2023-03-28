<?php

    $data=file_get_contents("php://input","r");
    $mydata=array();
    $mydata=json_decode($data,true);

    if(isset($mydata["id"]) && isset($mydata["email"])){
        if(($mydata["id"]) != "" && $mydata["email"] != ""){

            $p_id = $mydata["id"];
            $p_email = $mydata["email"];
            
            require_once("plantdbtools.php");
            $link = create_connect();

            $sql="UPDATE member SET Email= '$p_email' WHERE ID = '$p_id'";
            
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