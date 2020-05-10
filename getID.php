<?php
include 'conexao.php';
$allids = array();
if(empty($_POST['pl'])){
$sqlGetData = "SELECT idMusic FROM music ORDER BY idMusic";
}else{
$plID = $_POST['pl'];
$plType = $_POST['typer'];
if($plType == 2){
$sqlGetData = "SELECT idMusic FROM music where idMusic IN (SELECT idMusic FROM musicplaylist WHERE idPL = $plID) ORDER BY idMusic";
}elseif($plType == 1){
$sqlGetData = "SELECT idMusic FROM music WHERE idAlbum = $plID ORDER BY idMusic";    
}
}
$getData = $db->prepare($sqlGetData);
$getData->execute();
if($getData->rowcount()>0){
    while ($rs = $getData->fetch(PDO::FETCH_OBJ) ){
        $allids[] = $rs->idMusic; 
    }
    echo json_encode($allids);
            
    }
