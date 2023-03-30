<?php
        require_once("plantdbtools.php");
        $link = create_connect();
        
        //SQL語法中的Group by 意思就是說，欄位內的資料若有不只一筆名稱相同的資料的話，就會把它們作為群組。
        $sql = "SELECT COUNT(UserState) as num,UserState FROM user 
        GROUP BY UserState 
        ORDER BY 
        CASE UserState 
            WHEN 'y' THEN 1
            WHEN 'n' THEN 2
        END";
           
        $result = execute_sql($link, "plantdb", $sql);
    
        if(mysqli_num_rows($result) > 0){
            $mydata =array();
            while($row = mysqli_fetch_assoc($result)){
            $mydata[]=$row; 
        }
            echo '{"state":true,"message":"會員狀態統計成功!","data":'.json_encode($mydata).'}';

         mysqli_close($link);    
        }else{
            echo '{"state": false, "message":"會員狀態統計失敗!'.mysqli_error($link).'"}';
        }

       
?>