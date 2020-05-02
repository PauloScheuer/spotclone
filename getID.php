<?php
include 'conexao.php';
$allids = array();
if(empty($_POST['pl'])){
$sqlGetData = "SELECT idMusic FROM music";
}else{
$plID = $_POST['pl'];
$sqlGetData = "SELECT idMusic FROM music where idMusic IN (SELECT idMusic FROM musicplaylist WHERE idPL = $plID)";
}
$getData = $db->prepare($sqlGetData);
$getData->execute();
if($getData->rowcount()>0){
    while ($rs = $getData->fetch(PDO::FETCH_OBJ) ){
        $allids[] = $rs->idMusic; 
    }
    echo json_encode($allids);
            
    }
