<?php
    //撈取所有的資料轉換成JSON格式輸出
    require_once("plantdbtools.php");
    //接收
    $data = file_get_contents("php://input","r");
    //轉成陣列
    $mydata = array();
    //從陣列轉成字串
    $mydata = json_decode($data,true);

    
    if(isset($mydata["pdate"]) && isset($mydata["pname"]) && isset($mydata["pnum"]) && isset($mydata["plocation"]) && isset($mydata["wdate"]) && isset($mydata["wtime"]) && isset($mydata["pdiscribe"])){
        if($mydata["pdate"] != "" && $mydata["pname"] != "" && $mydata["pnum"] != "" && $mydata["plocation"] != "" && $mydata["wdate"] != "" && $mydata["wtime"] != "" && $mydata["pdiscribe"] != ""){

            $p_username = $mydata["username"];
            $p_date = $mydata["pdate"];
            $p_name = $mydata["pname"];
            $p_num = $mydata["pnum"];
            $p_location = $mydata["plocation"];
            $p_wdate = $mydata["wdate"];
            $p_wtime = $mydata["wtime"];
            $p_discribe = $mydata["pdiscribe"];

            $servername = "127.0.0.1";
            $username = "owner";
            $password = "Pt//12345678";
            $dbname = "plantdb";

            $conn = mysqli_connect($servername,$username,$password,$dbname);

            mysqli_query($conn ,'SET NAMES utf8;');

            $sql = "INSERT INTO c_plant(Username,Pdate,Pname,Pnum,Plocation,Wdate,Wtime,Pdiscribe) VALUES ('$p_username','$p_date','$p_name','$p_num','$p_location','$p_wdate','$p_wtime','$p_discribe')";

            if(mysqli_query($conn,$sql)){
                echo'{"state": true, "message":"新增資料成功!"}';
            }else{
                echo'{"state": false, "message":"新增資料失敗!錯誤代碼或相關訊息"}';
            }
            mysqli_close($conn);
        }else{
            echo '{"state": false, "message":"欄位不得為空白!"}';
        }
    }else{
        echo '{"state": false, "message":"缺少規定欄位!"}';
    }
?>