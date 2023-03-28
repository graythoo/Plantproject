<?php
        require_once("plantdbtools.php");
        $link = create_connect();
    
        //排序男性和女性
        $sql = "SELECT COUNT(Gender) AS num,gender FROM user GROUP BY Gender 
        ORDER BY 
        CASE gender
            WHEN '男性' THEN 1
            WHEN '女性' THEN 2
        END";
           
        $result = execute_sql($link, "plantdb", $sql);
    
        if(mysqli_num_rows($result) > 0){
            $mydata =array();
            while($row = mysqli_fetch_assoc($result)){
            $mydata[]=$row; 
        }
            echo '{"state":true,"message":"會員性別統計成功!","data":'.json_encode($mydata).'}';

         mysqli_close($link);    
        }else{
            echo '{"state": false, "message":"會員性別統計失敗!'.mysqli_error($link).'"}';
        }

       
?>