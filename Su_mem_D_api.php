<?php
//{"id":"xx"}
//{"state": true, "message":"刪除會員成功!"}
//{"state": false, "message":"刪除會員失敗!錯誤代碼或相關訊息"}
//{"state": false, "message":"欄位不得為空白!"}
//{"state": false, "message":"缺少規定欄位!"}!"}
    $data = file_get_contents("php://input", "r");
    $mydata = array();
    $mydata = json_decode($data, true);

    if (isset($mydata["id"])) {
        if ($mydata["id"] != "") {

            $p_id = $mydata["id"];
            $p_username = $mydata["username"];

            require_once("plantdbtools.php");

            $conn = create_connect();

            //刪除檔案夾中的所有檔案
            $sql01 = "SELECT Pic_path FROM plantlist WHERE Username = '$p_username'";
            $result01 = execute_sql($conn, "plantdb", $sql01);


            if($result01) {
                //mysqli_fetch_all可一次讀取全部的資料以獲取數據
                $rows = mysqli_fetch_all($result01, MYSQLI_ASSOC);
                //再使用迴圈逐一刪除
                foreach($rows as $row) {
                    //是否存在
                    if(file_exists($row['Pic_path'])) {
                        unlink($row['Pic_path']);//刪除資料
                    }
                }
            }

            //刪除使用者的帳號
            $sql02 = "DELETE FROM user WHERE ID = '$p_id'";
            $result02 = execute_sql($conn, "plantdb", $sql02);

            //假如image和c_plant資料庫裡有資料才要刪除
            if (isset($mydata["username"]) && $mydata["username"] != "") {
                $p_username = $mydata["username"];

                $sql03 = "DELETE FROM Image WHERE Username = '$p_username'";
                $result03 = execute_sql($conn, "plantdb", $sql03);

                $sql04 = "DELETE FROM c_plant WHERE Username = '$p_username'";
                $result04 = execute_sql($conn, "plantdb", $sql04);
            }

            //mysqli_affected_rows那行為受影響的行數為一(真的有存在這一筆才要刪)
            if ($result02 || $result03 || $result04 && mysqli_affected_rows($conn) == 1) {
                echo '{"state": true, "message":"刪除會員成功!"}';
            } else {
                echo '{"state": false, "message":"刪除會員失敗!' . mysqli_error($conn) . '"}';
            }
            mysqli_close($conn);
        } else {
            echo '{"state":false,"message":"欄位不得為空白"}';
        }
    } else {
        echo '{"state":false,"message":"缺少規定欄位"}';
    }

?>