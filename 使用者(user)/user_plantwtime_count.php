<?php
        require_once("plantdbtools.php");
        $link = create_connect();
    
        //使用 TIME_FORMAT 函數將 Wtime 轉換為時分秒的格式，然後再與固定的時間點（12:00:00 和 18:00:00）進行比較，以得到時間區段
        //並且按照早中晚排列順序
        $sql = "SELECT 
                CASE
                    WHEN TIME_FORMAT(Wtime, '%H:%i:%s') < '12:00:00' THEN '早上'
                    WHEN TIME_FORMAT(Wtime, '%H:%i:%s') >= '12:00:00' AND TIME_FORMAT(Wtime, '%H:%i:%s') < '18:00:00' THEN '下午'
                    ELSE '晚上'
                END AS time_period,
                COUNT(*) AS num
                FROM plantlist
                GROUP BY time_period
                ORDER BY 
                    CASE time_period 
                        WHEN '早上' THEN 1
                        WHEN '下午' THEN 2
                        ELSE 3
                    END";

        $result = execute_sql($link, "plantdb", $sql);
    
        if(mysqli_num_rows($result) > 0){
            $mydata =array();
            while($row = mysqli_fetch_assoc($result)){
            $mydata[]=$row; 
        }
            echo '{"state":true,"message":"植物澆花時間統計成功!","data":'.json_encode($mydata).'}';

         mysqli_close($link);    
        }else{
            echo '{"state": false, "message":"植物澆花時間統計失敗!'.mysqli_error($link).'"}';
        }
