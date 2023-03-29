<?php
    //input:
    //{"uid01":"xxx","uid02":"xxx"}
    //output:
    // {"state": true, "message":"登入狀態確認成功!","data":單筆會員相關資料}
    // {"state": false, "message":"登入狀態確認失敗!錯誤代碼或相關訊息"}
    // {"state": false, "message":"欄位不得為空白!"}
    // {"state": false, "message":"缺少規定欄位!"}
    $data = file_get_contents("php://input","r"); //"r是變數"
    $mydata = array();
    $mydata = json_decode($data,true);

    if(isset($mydata["uid01"]) && isset($mydata["uid02"])){
        if($mydata["uid01"] != "" && $mydata["uid02"] != ""){

            $p_uid01 = $mydata["uid01"];
            $p_uid02 = $mydata["uid02"];

            require_once("plantdbtools.php");
            
            $link = create_connect();

            $sql = "SELECT ID,Username,Gender,City,Tel,Email,UserState,Created_at FROM user WHERE UID01='$p_uid01' AND UID02='$p_uid02'";

            $result = execute_sql($link,"plantdb",$sql);

            if(mysqli_num_rows($result) == 1){
                //UID合法
                $userData = array();//先轉成陣列
                $row = mysqli_fetch_assoc($result);//再把它存進去
                $userData[] = $row;//變成二維陣列
                echo '{"state": true, "message":"登入狀態確認成功!","data":'.json_encode($userData).'}';
            }else{
                //UID非法
                echo '{"state": false, "message":"登入狀態確認失敗!'.mysqli_error($link).'"}';
            }
            mysqli_close($link);            
        }else{
            echo '{"state":false,"message":"欄位不得為空白"}'; 
        }
    }else{
        echo '{"state":false,"message":"缺少規定欄位"}'; 
    }
    
?>