<?php
    if(isset($_FILES['file']["name"]) && $_FILES['file']["name"]!=""){
        if($_FILES['file']["type"] == "image/png" || $_FILES['file']["type"] == "image/jpeg" || $_FILES['file']['size'] < 2 * 1024 * 1024){

            //日期為依據 產生上傳檔案的檔名
            //將$_FILES['file']["name"] 副檔名取出 檔名格式 upload/20230204104410.png
            $ext = pathinfo($_FILES['file']["name"], PATHINFO_EXTENSION);//副檔名
            //echo $ext;
            $filename = date("YmdHis").".".$ext;
            
            $location = "upload/".$filename;//檔案儲存的路徑
               //echo $location;

             if(move_uploaded_file($_FILES['file']["tmp_name"], $location)){
                 //檔案傳輸成功, 收集檔案相關資訊
                //{"state": true, "message":"檔案上傳成功!", "data": json格式的檔案相關資訊}

                //將檔案路徑存入資料

                // 連接到資料
                $servername = "127.0.0.1";
                $username = "owner";
                $password = "Pt//12345678";
                $dbname = "plantdb";
                
                $conn = mysqli_connect($servername,$username,$password,$dbname);

                mysqli_query($conn ,'SET NAMES utf8');
                
                $id = $_POST['id'];
                $p_username = $_POST['username'];

                $sql01 = "SELECT Pic_path FROM Image WHERE ID ='$id' AND Username = '$p_username'";
                $result = mysqli_query($conn, $sql01);
                if($result) {
                    if($row = mysqli_fetch_assoc($result)) {
                        // 刪除原本的檔案
                        if(file_exists($row['Pic_path'])) {
                            unlink($row['Pic_path']);
                        }
                    }
                }

                $sql02 = "UPDATE Image SET Pic_path = '$location' WHERE ID ='$id' AND Username = '$p_username'";
            
                if(mysqli_query($conn,$sql02)){
                    echo '{"state":true,"message":"更新會員成功!"}';
                }else{
                    echo '{"state":false,"message":"更新會員失敗!'.$sql02.mysqli_error($conn).'"}'; 
                }
                mysqli_close($conn);


                $datainfo = array();
                $datainfo["name"] = $_FILES['file']["name"]; //原始檔名
                $datainfo["type"] = $_FILES['file']["type"]; //格式
                $datainfo["size"] = $_FILES['file']["size"]; //檔案大小
                $datainfo["tmp_name"] = $_FILES['file']["tmp_name"]; //暫存檔名稱
                $datainfo["error"] = $_FILES['file']["error"]; //錯誤代碼
                echo '{"state": true, "message":"檔案上傳成功!", "data": '.json_encode($datainfo).'}';
            }else{
                //檔案傳輸失敗
                echo '{"state": false, "message":"檔案上傳失敗!"}';
            }
        }else{
            echo '{"state": false, "message":"檔案格式錯誤(png/jpeg/超過2MB)!"}';
        }
    }else{
        echo '{"state": false, "message":"檔案不存在或未選取檔案!"}';
    }

?>