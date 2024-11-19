<?php
session_start();
if(isset($_SESSION['id'])&& isset($_SESSION['user_name'])){
    header("Location: ../html/home.html");
    exit();
}else{
    header("Location: ../html/index.html");
    exit();
}
?>