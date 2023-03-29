<?php
        require_once("plantdbtools.php");
        $link = create_connect();
    
        $sql = "SELECT COUNT(Pname) AS num,Pname FROM plantlist GROUP BY Pname";

        $result = execute_sql($link, "plantdb", $sql);
    
        if(mysqli_num_rows($result) > 0){
            $mydata =array();
            while($row = mysqli_fetch_assoc($result)){
            $mydata[]=$row; 
        }
            echo '{"state":true,"message":"植物名字統計成功!","data":'.json_encode($mydata).'}';

         mysqli_close($link);    
        }else{
            echo '{"state": false, "message":"植物名字統計失敗!'.mysqli_error($link).'"}';
        }

?>