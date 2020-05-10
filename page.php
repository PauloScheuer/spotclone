<?php
include './conexao.php';
$id= $_GET['id'];
$type = $_GET['type'];
//redefine style
echo "<style>"
. "#content{display:flex;"
        . "flex-direction:column;"
        . "color: white"
        . "}"
        . "</style>";
if($type == "alb"){
    $sqlAlb = "SELECT * FROM album WHERE album.idAlbum = $id ";
    $sqlAlbDo = $db->prepare($sqlAlb);
    $sqlAlbDo->execute();
    if($sqlAlbDo->rowcount()>0){
        while($rs = $sqlAlbDo->fetch(PDO::FETCH_OBJ)){
           echo "<div class='albumData'><img src='photos/albuns/$rs->photoAlbum' width=200 height=200>"
                ."<h1>$rs->nameAlbum</h1>";
               $sqlAlbArt = "SELECT * FROM artist WHERE artist.idArtist IN"
                       . " (SELECT idArtist FROM albumartist WHERE albumartist.idAlbum = $id)";
               $sqlAlbArtDo = $db->prepare($sqlAlbArt);
               $sqlAlbArtDo->execute();
                if($sqlAlbArtDo->rowcount()>0){
                echo "<section ><h1>Por:</h1>";    
                while($rss = $sqlAlbArtDo->fetch(PDO::FETCH_OBJ)){
                echo "<h3>".$rss->nameArtist."</h3>";
                }
                 }
            echo "</section></div>";     
        }
    }
    $sql= "SELECT * FROM music WHERE music.idAlbum = $id";
    $sqlDo = $db->prepare($sql);
    $sqlDo->execute();
    if($sqlDo->rowcount()>0){
        echo "<h3 style='margin-left:50px;'>".$sqlDo->rowCount()." músicas</h3>";;
        echo "<div class='list'>";
        while($rs = $sqlDo->fetch(PDO::FETCH_OBJ)){
            echo "<div onclick='tocar($rs->idMusic,true,$id,1)' class='itemlist'>".str_replace("***", "'", $rs->nameMusic);
            $sqlfeat = "SELECT * FROM `artist` WHERE (idArtist NOT IN (SELECT idArtist FROM albumartist WHERE idAlbum = $id))"
                    . " AND (idArtist IN (SELECT idArtist FROM musicartist WHERE idMusic = $rs->idMusic))";
            $featDo = $db->prepare($sqlfeat);
            $featDo->execute();
            $cont = 0;
            if($featDo->rowcount()>0){
                echo "<section class='ft'> FT. ";
                while ($rsf = $featDo->fetch(PDO::FETCH_OBJ)){
                    if($cont==0){$plus = " ";}else{$plus=" + ";}
                    echo $plus.$rsf->nameArtist;
                    $cont++;
                }
                
            }else{
                echo "<section>";
            }
            echo "<div class='playButton'><img src='icons/play.svg' id='imgPlayCard$rs->idMusic'></div></section></div><br>";
            
        }
        echo "</div>";
    }
}

