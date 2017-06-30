<?php

if(!isset($_GET["number"])){
    die("Get number is not isset");
}


if($_GET["number"]%2){
    head("Location: odd.php");
}else{
    header("Location: even.php");
}