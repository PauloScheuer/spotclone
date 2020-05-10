<?php
if(!empty($_GET['search'])){
    $search = $_GET['search'];
    $where = "WHERE ((album.nameAlbum LIKE '%$search%') or"
            . " ( idAlbum IN (SELECT idAlbum FROM albumartist WHERE idArtist IN "
            . "(SELECT idArtist FROM artist WHERE nameArtist LIKE '%$search%')) )  )";
}else{
    $search = "0";
    $where = "";
}
include './conexao.php';
if(!empty($_GET['page'])){
    $page = $_GET['page'];
}else{
    $page = 1;
}
$lim = $page*10;
$sql = "SELECT * FROM album $where LIMIT $lim";
$sqlDo = $db->prepare($sql);
$sqlDo->execute();
if ($sqlDo->rowcount() > 0) {
    echo "<div id='contentgrid'>";
    while ($rs = $sqlDo->fetch(PDO::FETCH_OBJ) ) {
        $namealbum = str_replace("***", "'", $rs->nameAlbum);
        $namealbum = str_replace("###", '"', $rs->nameAlbum);
        echo    "<style>"
                . "#album$rs->idAlbum{"
                . "background-image: url('photos/albuns/$rs->photoAlbum');"
                . "background-size: cover"
                . "}"
                . "</style>"
        . "<div class='album' id='album$rs->idAlbum' onclick='openAlbum($rs->idAlbum)' >"
                . "<div class='nameMusic' ><p>$namealbum</p></div>";
        $sql2 = "SELECT * FROM artist, albumartist where artist.idArtist = albumartist.idArtist and albumartist.idAlbum=$rs->idAlbum";
        $sql2Do = $db->prepare($sql2);
        $sql2Do->execute();
        echo "<div class='nameArtist'><p>";
        if($sql2Do->rowcount()>0){
            while($rss = $sql2Do->fetch(PDO::FETCH_OBJ)){
                echo "$rss->nameArtist+";
            }
        }
        echo "</p></div>";
        echo "</div>";
    }
    $sqltotal = "SELECT * FROM album $where";
    $total = $db->prepare($sqltotal);
    $total->execute();
    $totalRegisters = $total->rowcount();
    if($lim<$totalRegisters){
    $href = "`listAlbum.php`";
    $load = "$search,$href";    
    echo "<img src='icons/plus-circle.svg' onclick='loadmore(".$load.")' id='load'/>"; 
    }
    echo "</div>";
} else {
    echo "Sem álbuns";
}




