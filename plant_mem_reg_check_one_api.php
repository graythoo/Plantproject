<?php
// {"username":"owner"}
// {"state": true, "message":"該帳號不存在，帳號可以使用"}
// {"state": false, "message":"帳號已存在，帳號不可以使用"}
// {"state": false, "message":"欄位不得為空白!"}
// {"state": false, "message":"缺少規定欄位!"}

$data = file_get_contents("php://input","r");
$mydata = array();
$mydata = json_decode($data,true);

if(isset($mydata["username"])){
    if($mydata["username"] != ""){

        $p_username = $mydata["username"];

        require_once("plantdbtools.php");
        $link = create_connect();
        
        $sql="SELECT Username FROM member WHERE Username = '$p_username'";

        $result = execute_sql($link,"plantdb",$sql);

        if(mysqli_num_rows($result) == 1){
            echo '{"state": false, "message":"帳號已存在，帳號不可以使用"}';
        }else{
            echo '{"state": true, "message":"該帳號不存在，帳號可以使用"}';
        }
        mysqli_close($link);            
    }else{
        echo '{"state":false,"message":"欄位不得為空白"}'; 
    }
}else{
    echo '{"state":false,"message":"缺少規定欄位"}'; 
}

?>