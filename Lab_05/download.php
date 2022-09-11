<?php
    if (!empty($_GET['file'])&&file_exists("register.csv")) {
        header("Location: https://enos.itcollege.ee/~baadam/ICD0007_LAB5/register.csv");
        exit;
    }else {
        echo 'This file does not exists';
    }
  
?>
