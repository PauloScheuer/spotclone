<?php
if(!empty($_GET['search'])){
    $search = $_GET['search'];
    $where = "and ( (music.nameMusic LIKE '%$search%') or (album.nameAlbum LIKE '%$search%') or"
            . " ( idMusic IN (SELECT idMusic FROM musicartist WHERE idArtist IN "
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
$sql = "SELECT * FROM music,album where music.idAlbum = album.idAlbum $where ORDER BY music.idMusic LIMIT $lim ";
$sqlDo = $db->prepare($sql);
$sqlDo->execute();
if ($sqlDo->rowcount() > 0) {
    //novo
    echo "<div id='contentgrid'>";
    while ($rs = $sqlDo->fetch(PDO::FETCH_OBJ) ) {
        echo    "<style>"
                . "#music$rs->idMusic{"
                . "background-image: url('photos/albuns/$rs->photoAlbum');"
                . "background-size: cover"
                . "}"
                . "</style>"
        . "<div class='music' id='music$rs->idMusic' onclick='tocar($rs->idMusic, true)' >"
                . "<div class='playButton'><img src='icons/play.svg' id='imgPlayCard$rs->idMusic'></div>"
                . "<div class='nameMusic' ><p>".str_replace("***", "'", $rs->nameMusic)."</p></div>";
        $sql2 = "SELECT * FROM artist, musicartist where artist.idArtist = musicartist.idArtist and musicartist.idMusic=$rs->idMusic";
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
    $sqltotal = "SELECT * FROM music,album where music.idAlbum = album.idAlbum $where";
    $total = $db->prepare($sqltotal);
    $total->execute();
    $totalRegisters = $total->rowcount();
    if($lim<$totalRegisters){
    $href = "`listMusic.php`";
    $load = "$search,$href";
    echo "<img src='icons/plus-circle.svg' onclick='loadmore(".$load.")' id='load'/>"; 
    }
    echo "</div>";
} else {
    echo "Sem músicas";
}


