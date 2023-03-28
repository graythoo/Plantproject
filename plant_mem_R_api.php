<?php
        require_once("plantdbtools.php");
        $link = create_connect();
    
        $sql = "SELECT Role,Name,Username,Email,Ext FROM member ORDER BY ID DESC";   
        $result = execute_sql($link, "plantdb", $sql);
    
        if(mysqli_num_rows($result) > 0){
            $mydata =array();
            while($row = mysqli_fetch_assoc($result)){
            $mydata[]=$row; 
        }
            echo '{"state":true,"message":"管理員讀取成功!","data":'.json_encode($mydata).'}';

         mysqli_close($link);    
        }else{
            echo '{"state": false, "message":"管理員讀取失敗!'.mysqli_error($link).'"}';
        }

       
?>