<?php
    // {"state": true, "message":"登入會員成功!"}
// {"state": false, "message":"登入會員失敗!錯誤代碼或相關訊息"}
// {"state": false, "message":"欄位不得為空白!"}
// {"state": false, "message":"缺少規定欄位!"}
$data=file_get_contents("php://input","r");
$mydata=array();
$mydata=json_decode($data,true);

if(isset($mydata["username"]) && isset($mydata["password"])){
    if(($mydata["username"]) != "" && $mydata["password"] != ""){
        
        $p_username=$mydata["username"];
        $p_password=$mydata["password"];
        
        require_once("plantdbtools.php");
        $link = create_connect();
        //找出相同帳號的那一筆資料
        $sql="SELECT Username,Password,UserState FROM member WHERE Username='$p_username'";

        $result = execute_sql($link,"plantdb",$sql);
        if(mysqli_num_rows($result) == 1){
            //該筆帳號存在，使用password_verify()確認密碼是否正確
            $row = mysqli_fetch_assoc($result);
            $password_hash = $row["Password"];
            if(password_verify($p_password,$password_hash)){
                //密碼驗證成功
                //產生UID並更新於資料庫(UID為登入時自動產生,若把它刪除，系統則會要求再次登入)
                //每次登入的$uid數值都會不一樣
                
                //UID(一個網站通常都會有多個uid,以保障使用者的安全)
                $uid01 = substr(md5(hash('sha256',rand())),0,8);
                $uid02 = substr(md5(hash('sha256',uniqid())),0,12);
                $uid03 = substr(md5(hash('sha256',rand())),0,8);
                $sql = "UPDATE member SET UID01 = '$uid01', UID02 = '$uid02',UID03 = '$uid03'  WHERE Username = '$p_username'";
                execute_sql($link,"plantdb",$sql);

                //撈取除了密碼以外的資訊
                $sql="SELECT ID,Username,UserState,UID01,UID02,UID03 FROM member WHERE Username = '$p_username'";
                $result = execute_sql($link,"plantdb",$sql);
                $row = mysqli_fetch_assoc($result);
                $userData = array();
                $userData[] = $row;//轉成陣列
                
                echo '{"state": true, "message":"登入會員成功!","data":'.json_encode($userData).'}';//encode變成json格式
            }else{
                //密碼驗證失敗
                echo '{"state": false, "message":"登入會員失敗!'.mysqli_error($link).'"}'; 
            }
        }else{
            //該筆帳號不存在
            echo '{"state": false, "message":"登入會員失敗!'.mysqli_error($link).'"}';
        }
        mysqli_close($link);
    }else{
        echo '{"state":false,"message":"欄位不得為空白"}'; 
    }
}else{
    echo '{"state":false,"message":"缺少規定欄位"}'; 
}
?>