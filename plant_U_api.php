<?php
    // require_once("plantdbtools.php");

    $data = file_get_contents("php://input","r");
    $mydata = array();
    $mydata = json_decode($data,true);

    if(isset($mydata["pdate"]) && isset($mydata["pname"]) && isset($mydata["pnum"]) && isset($mydata["plocation"]) && isset($mydata["wdate"]) && isset($mydata["wtime"]) && isset($mydata["pdiscribe"])){
        if($mydata["pdate"] != "" && $mydata["pname"] != "" && $mydata["pnum"] != "" && $mydata["plocation"] != "" && $mydata["pdate"] != "" && $mydata["wtime"] != "" && $mydata["pdiscribe"] != ""){
            
            $p_ID = $mydata["ID"];
            $p_date = $mydata["pdate"];
            $p_name = $mydata["pname"];
            $p_num = $mydata["pnum"];
            $p_location = $mydata["plocation"];
            $p_wdate = $mydata["wdate"];
            $p_wtime = $mydata["wtime"];
            $p_discribe = $mydata["pdiscribe"];

            // $servername = "localhost";
            // $username = "id19936093_owner";
            // $password = "Pt//12345678";
            // $dbname = "id19936093_plantdb";
            $servername = "127.0.0.1";
            $username = "owner";
            $password = "Pt//12345678";
            $dbname = "plantdb";
            
            $conn = mysqli_connect($servername,$username,$password,$dbname);
            mysqli_query($conn ,'SET NAMES utf8;');

            $sql = "UPDATE c_plant SET Pdate = '$p_date',Pname = '$p_name',Pnum = '$p_num',Plocation = '$p_location',Wdate = '$p_wdate',Wtime = '$p_wtime',Pdiscribe = '$p_discribe' WHERE ID ='$p_ID'";
        
            // $result = execute_sql($conn,"id19936093_plantdb",$sql);
            if(mysqli_query($conn,$sql)){
                echo '{"state": true, "message":"更新資料成功!"}';
            }else{
                echo '{"state":false,"message":"更新資料失敗!錯誤代碼或相關訊息"}'.$sql.mysqli_error($conn);
            }
            mysqli_close($conn);
        }else{
            echo '{"state": false, "message":"欄位不得為空白!"}';
        }
    }else{
        echo '{"state": false, "message":"缺少規定欄位!"}';
    }
    
?>