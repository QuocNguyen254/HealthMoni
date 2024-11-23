<?php

session_start();
include "connect.php";
$_SESSION['doctorName'] = "";
$_SESSION['doctorMajor'] = "";
    if(isset($_POST['uname']) && isset($_POST['upass'])){
        function validate($data){
            $data = trim($data);
            $data = stripcslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }
        
        $uname = validate($_POST['uname']);
        $pass = validate($_POST['upass']);
        if(empty($uname)){
            header("Location: ../Frontend/index.html");
            exit();
        }else if(empty($pass)){
            header("Location: ../Frontend/index.html");
            exit();
        }else{
            
            $sql = "SELECT * FROM users WHERE name='$uname' AND pass='$pass'";
            $result = $conn->query($sql);


            if ($result->num_rows == 1){
                $row = $result->fetch_assoc();
                if($row['name'] == $uname && $row['pass'] == $pass){
                    $_SESSION['user_name'] = $row['name'];
                    $_SESSION['name'] = $row['name'];
                    $_SESSION['id'] = $row['name'];
                    if ($row['usertype']=="Patient"){
                        header("Location: ../Frontend/home.php");
                    }else{
                        header("Location: ../Frontend/home_doctor.php"); 
                    }
                    exit();
                }else{
                    header("Location: ../Frontend/index.html");
                    exit();
                }
            }else{
                header("Location: ../Frontend/index.html");
                exit();
            }
        }
    }else{
        header("Location: ../Frontend/index.html");
        exit();
    }











?>