<?php
    //input:
    //{"id":"xx","userState":"y"}
    //{"id":"xx","userState":"n"}
    //output:
    //{"state": true, "message":"更新會員狀態成功!"}
    //{"state": false, "message":"更新會員狀態失敗!錯誤代碼或相關訊息"}
    //{"state": false, "message":"欄位不得為空白!"}
    //{"state": false, "message":"缺少規定欄位!"}
    $data = file_get_contents("php://input","r"); //"r是變數"
    $mydata = array();
    $mydata = json_decode($data,true);

    if(isset($mydata["id"]) && isset($mydata["userState"])){
        if($mydata["id"] != "" && $mydata["userState"] != ""){

            $p_id = $mydata["id"];
            $p_userState = $mydata["userState"];

            require_once("plantdbtools.php");
            
            $link = create_connect();

            $sql = "UPDATE member SET UserState = '$p_userState' WHERE ID = '$p_id'";
            //更新會員狀態成功而不是僅判斷語法執行正確?????
            if(execute_sql($link,"plantdb",$sql) && mysqli_affected_rows($link) == 1){
                echo '{"state": true, "message":"更新會員狀態成功!"}';
            }else{
                echo '{"state": false, "message":"更新會員狀態失敗!'.mysqli_error($link).$sql.'"}';
            }
            mysqli_close($link);            
        }else{
            echo '{"state":false,"message":"欄位不得為空白"}'; 
        }
    }else{
        echo '{"state":false,"message":"缺少規定欄位"}'; 
    }
    
?>