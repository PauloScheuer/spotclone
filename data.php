<?php
include 'conexao.php';
$id= $_POST['id'];
$sqlGetData = "SELECT fileMusic,nameMusic,photoAlbum FROM music,album where music.idAlbum = album.idAlbum and idMusic = $id";
$getData = $db->prepare($sqlGetData);
$getData->execute();
if($getData->rowcount()>0){
    while ($rs = $getData->fetch(PDO::FETCH_OBJ) ){
        $data = array();
        $data[] = $rs->fileMusic;
        $data[] = $rs->nameMusic;
        $data[] = $rs->photoAlbum;
    }
    echo json_encode($data);
            
    }



