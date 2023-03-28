<?php
    //連線到資料庫
    function create_connect(){
        
        $link = mysqli_connect("127.0.0.1","owner","Pt//12345678")
            or die("連線失敗".mysqli_connect_error());
            return $link;
    }
    
    //寫SQL指令後執行測試下的SQL指令是否成功
    function execute_sql($link,$dbname,$sql){
        mysqli_query($link ,'SET NAMES utf8');
        mysqli_select_db($link,$dbname)
            or die("連線失敗".mysqli_connect_error($link));

            $result = mysqli_query($link,$sql);
            return $result;
    }
    
?>