<?php


  
 $con = "mysql:host=localhost;dbname=testspotclonedb";
try{
    
    
$db = new PDO($con,"root","");
} catch (PDOException $e) {
    echo $e->getMessage();
}

