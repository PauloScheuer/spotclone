<?php


  
 $con = "mysql:host=localhost;dbname=spotclonedb";
try{
    
    
$db = new PDO($con,"root","");
} catch (PDOException $e) {
    echo $e->getMessage();
}

