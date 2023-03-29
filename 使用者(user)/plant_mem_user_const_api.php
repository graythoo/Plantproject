<?php
        require_once("plantdbtools.php");
        $link = create_connect();
    
        $sql = "SELECT COUNT(*) AS total_member FROM user";
           
        $result = execute_sql($link, "plantdb", $sql);
    
        if(mysqli_num_rows($result) > 0){
            $mydata =array();
            while($row = mysqli_fetch_assoc($result)){
            $mydata[]=$row; 
        }
            echo '{"state":true,"message":"會員總數統計成功!","data":'.json_encode($mydata).'}';

         mysqli_close($link);    
        }else{
            echo '{"state": false, "message":"會員總數統計失敗!'.mysqli_error($link).'"}';
        }

       
?>