<?php
    $data = file_get_contents("php://input","r");
    $mydata = array();
    $mydata = json_decode($data,true);

    if(isset($mydata["ID"]) && isset($mydata["username"])){
        if($mydata["ID"] != "" && $mydata["username"] != ""){
            $p_ID = $mydata["ID"];
            $p_username = $mydata["username"];

            $servername = "127.0.0.1";
            $username = "owner";
            $password = "Pt//12345678";
            $dbname = "plantdb";

            $conn = mysqli_connect($servername,$username,$password,$dbname);

            //刪除資料夾中的檔案
            
            $sql01 = "SELECT Pic_path FROM Image WHERE ID ='$p_ID' AND Username = '$p_username'";
            $result01 = mysqli_query($conn, $sql01);
            if($result01) {
                if($row = mysqli_fetch_assoc($result01)) {
                    // 刪除原本的檔案
                    if(file_exists($row['Pic_path'])) {
                        unlink($row['Pic_path']);//刪除檔案
                    }
                }
            }

            $sql02 = "DELETE FROM Image WHERE ID='$p_ID' AND Username = '$p_username'";

            $sql03 = "DELETE FROM c_plant WHERE ID='$p_ID' AND Username = '$p_username'";

            $result02 = mysqli_query($conn,$sql02);
            $result03 = mysqli_query($conn,$sql03);

            if($result02 && $result03 && mysqli_affected_rows($conn) == 1 ){
                echo '{"state":true,"message":"刪除資料成功!"}';
            } else {
                echo '{"state":false,"message":"刪除資料失敗!錯誤代碼或相關訊息"}';
            }

            mysqli_close($conn);
        } else {
            echo '{"state":false,"message":"欄位不得為空白"}'; 
        }
    } else {
        echo '{"state":false,"message":"缺少規定欄位"}'; 
    }
?>
