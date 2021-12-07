<?php 
    if(!defined('SECURITY')){
        die('Bạn không có quyền truy cập file này !!!');
    }
    $conn = new mysqli('localhost', 'root', '','mobile_shop');

    if($conn){
        mysqli_query($conn, "SET NAMES 'utf8'");
    }else{
        die('Không thể kết nối tới Mysql server');
    }
?>