<?php
    //{"id":"xx"}
    //{"state": true, "message":"讀取成功!","data":單筆會員資料}
    //{"state": false, "message":"讀取失敗!錯誤代碼或相關訊息"}
    //{"state": false, "message":"欄位不得為空白!"}
    //{"state": false, "message":"缺少規定欄位!"}
    $data = file_get_contents("php://input","r");
    $mydata = array();
    $mydata = json_decode($data,true);

    if(isset($mydata["username"])){
        if($mydata["username"] != ""){

            $p_username = $mydata["username"];

            require_once("plantdbtools.php");
            $link = create_connect();
            
            $sql="SELECT ID,Username,Role,Name,Ext,Email,Created_at FROM member WHERE Username = '$p_username'";

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