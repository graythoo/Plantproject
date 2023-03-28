<?php
    //接收登入的帳號訊息,讀取其帳號、性別、城市、電話、電子郵件
    $data = file_get_contents("php://input","r");
    $mydata = array();
    $mydata = json_decode($data,true);

    if(isset($mydata["username"])){
        if($mydata["username"] != ""){

            $p_username = $mydata["username"];

            require_once("plantdbtools.php");
            $link = create_connect();
            
            //找出相同帳號的那一筆資料
            $sql="SELECT ID,Username,Gender,City,Tel,Email,Created_at FROM user WHERE Username = '$p_username'";

            $result = execute_sql($link,"plantdb",$sql);

            if(mysqli_num_rows($result) == 1){
                //正確找到ID所對應的資料
               $row = mysqli_fetch_assoc($result);
               echo'{"state":true,"message":"讀取成功!","data":'.json_encode($row).'}';
            }else{
                //查無ID所對應的資料
                echo '{"state": false, "message":"讀取失敗!"}';
            }
            mysqli_close($link);            
        }else{
            echo '{"state":false,"message":"欄位不得為空白"}'; 
        }
    }else{
        echo '{"state":false,"message":"缺少規定欄位"}'; 
    }
    
?>