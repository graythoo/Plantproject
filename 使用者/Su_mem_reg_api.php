<?php
    // input:
    // {"username":"owner","password":"123456","email":"xxx@ccc.com"}
    // output:
    // {"state": true, "message":"註冊會員成功!"}
    // {"state": false, "message":"註冊會員失敗!錯誤代碼或相關訊息"}
    // {"state": false, "message":"欄位不得為空白!"}
    // {"state": false, "message":"缺少規定欄位!"}

    $data=file_get_contents("php://input","r");
    $mydata=array();
    $mydata=json_decode($data,true);

    if(isset($mydata["username"]) && isset($mydata["password"]) && $mydata["gender"] && $mydata["city"] && $mydata["tel"] && isset($mydata["email"])){
        if(($mydata["username"]) != "" && $mydata["password"] != "" && $mydata["gender"] != "" && $mydata["city"] != "" && $mydata["tel"] != "" && $mydata["email"] != ""){
            
            $p_username=$mydata["username"];
            $p_password=$mydata["password"];
            $p_gender=$mydata["gender"];
            $p_city=$mydata["city"];
            $p_tel=$mydata["tel"];
            $p_email=$mydata["email"];

            
            //password_hash 雜湊函數加密處理
            $p_password=password_hash($p_password,PASSWORD_DEFAULT);
            
            require_once("plantdbtools.php");
            $link = create_connect();

            $sql="INSERT INTO user(Username,Password,Gender,City,Tel,Email) VALUES ('$p_username','$p_password','$p_gender','$p_city','$p_tel','$p_email')";
            
            if(execute_sql($link,"plantdb",$sql)){
                echo '{"state":true,"message":"會員註冊成功!"}';
            }else{
                echo '{"state":false,"message":"會員註冊失敗!'.$sql.mysqli_error($link).'"}'; 
            }
            mysqli_close($link);
        }else{
            echo '{"state":false,"message":"欄位不得為空白"}'; 
        }
    }else{
        echo '{"state":false,"message":"缺少規定欄位"}'; 
    }
?>