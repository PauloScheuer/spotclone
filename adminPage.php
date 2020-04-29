<!DOCTYPE html>
<!--
To change this license //header, choose License //Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
        <script type="text/javascript" src="js/jquery.js"></script>
        <script type="text/javascript" src="js/main.js"></script>
        <script type="text/javascript" >
            var contrB = 1;
        function moreArtists(div){
            if(div !== 'one'){
            actDiv = div;
            if (sessionStorage.getItem('div')===null){
            }else{
                sessionDiv = sessionStorage.getItem('div');
                if(actDiv == sessionDiv){
                }else{
                    contrB = 1;
                }
            }
            sessionStorage.setItem('div',actDiv);
            divTrue = div;
            }else{
            divTrue = "";
            }
            divT = "."+div;
            var $DinSelect = document.querySelector(divT),
            HTMLTemp = $DinSelect.innerHTML,
            HTMLNew = "<select name='"+divTrue+"AlbArt"+contrB+"'><?php
            echo "<option value='null'>------</option>";
                include './conexao.php';
                $sql = "SELECT idArtist,nameArtist FROM artist";
                $sqlDo = $db->prepare($sql);
                $sqlDo->execute();
                if($sqlDo->rowcount() > 0){
                    while ($rs = $sqlDo->fetch(PDO::FETCH_OBJ)){
                        echo "<option value='$rs->idArtist'>$rs->nameArtist</option>";
                    }
                }
                ?></select>\n\
<input type='hidden' value='"+contrB+"' name='co'></select><br>";
            HTMLTemp =  HTMLTemp + HTMLNew;
            $DinSelect.innerHTML = HTMLTemp;
            contrB++;
        }
        
        var contrBG =1;
        function moreGenres(div){
           if(contrBG<=4){
               actDiv = div;
            if (sessionStorage.getItem('div')===null){
            }else{
                sessionDiv = sessionStorage.getItem('div');
                if(actDiv == sessionDiv){
                }else{
                    contrBG = 1;
                }
            }
            sessionStorage.setItem('div',actDiv);
               divR = "."+div;
               if(contrBG<=3){
               var $DinSelectG = document.querySelector(divR),
               HTMLTemp = $DinSelectG.innerHTML,
               HTMLNew = "<select name='"+div+"MusGen"+contrBG+"'><?php
                echo "<option value='null'>------</option>";
                include './conexao.php';
                $sqlGenr = "SELECT idGenre,nameGenre FROM genre";
                $sqlGenrDo = $db->prepare($sqlGenr);
                $sqlGenrDo->execute();
                if($sqlGenrDo->rowcount() > 0){
                    while ($rs = $sqlGenrDo->fetch(PDO::FETCH_OBJ)){
                        echo "<option value='$rs->idGenre'>$rs->nameGenre</option>";
                    }
                }
                ?></select>\n\
                <input type='hidden' value='"+contrBG+"' name='cg'></select><br>";
               HTMLTemp =  HTMLTemp + HTMLNew;
               $DinSelectG.innerHTML = HTMLTemp;
               contrBG++;
           }
        }
    }
        
        var contrBM = 1;
        function moreMusics(){
            two = '"two'+contrBM+'"';
            twoG = '"twog'+contrBM+'"';
            var $DinSelectM = document.querySelector('.DinSelectM'),
            HTMLTemp = $DinSelectM.innerHTML,
            HTMLNew = "Nome<input name='nameMusic"+contrBM+"'><br>\n\
                Arquivo<input type='file' name='fileMusic"+contrBM+"'><br>\n\
                Outro artista<a onclick='moreArtists("+two+")'>+</a>\n\
                \n\<div class="+two+"></div>\n\
                \n\Gênero(s) <a onclick='moreGenres("+twoG+")'>+</a>\n\
                \n\<div class="+twoG+"></div>\n\
                <input type='hidden' value='"+contrBM+"' name='c'></select><br>";
            HTMLTemp =  HTMLTemp + HTMLNew;
            $DinSelectM.innerHTML = HTMLTemp;
            contrBM++;
        }
        </script>
    </head>
    <body>
        <div class="insertGen">
        <h1>Inserir gênero</h1>
        <form action="adminPage.php" method="POST">
            Nome<input name="nameGen"><br>
            <input type="submit" name="subGen">
        </form>
        </div>
        <div class="insertArt">
        <h1>Inserir artista</h1>
        <form action="adminPage.php" method="POST" enctype="multipart/form-data">
            Nome<input name="nameArt"><br>
            Foto<input type="file" name="photoArt"><br>
            Bio<textarea name="bioArt"></textarea><br>
            País de Origem<select name="countryArt">
                <?php
                include './conexao.php';
                $sql = "SELECT * FROM country";
                $sqlDo = $db->prepare($sql);
                $sqlDo->execute();
                if($sqlDo->rowcount() > 0){
                    while ($rs = $sqlDo->fetch(PDO::FETCH_OBJ)){
                        echo "<option value='$rs->idCountry'>$rs->nameCountry</option>";
                    }
                }
                ?>
            </select><br>
            <input type="submit" name="subArt">
        </form>
        </div>
        <div class="insertAlb">
        <h1>Inserir album</h1>
        <form action="adminPage.php" method="POST" enctype="multipart/form-data">
            Nome<input name="nameAlb"><br>
            Foto<input type="file" name="photoAlb"><br>
            Tipo de Album<select name="typeAlb">
                <option value="single">Single</option>
                <option value="album">Album</option>
            </select><br>
            Artista(s)
            <a onclick="moreArtists('one')" >+</a>
            <div class="one"></div>
            <input type="submit" name="subAlb">
        </form>
        </div>
        <div class="insertMusic">
        <h1>Inserir música</h1>
        <form action="adminPage.php" method="POST" enctype="multipart/form-data">
            Álbum<select name="album">
                <?php
                include './conexao.php';
                $sql = "SELECT * FROM album";
                $sqlDo = $db->prepare($sql);
                $sqlDo->execute();
                if($sqlDo->rowcount() > 0){
                    while ($rs = $sqlDo->fetch(PDO::FETCH_OBJ)){
                        echo "<option value='$rs->idAlbum'>$rs->nameAlbum</option>";
                    }
                }
                ?>
            </select><br>
            <a onclick="moreMusics()">+</a>
            <div class="DinSelectM"></div>
            
            <input type="submit" name="subMusic">
        </form>
        </div>
    </body>
</html>
<?php
//inserção de gênero no bd
if(!empty($_POST['subGen']) and !empty($_POST['nameGen'])){
    include './conexao.php';
    $nameGen = $_POST['nameGen'];
    $sqlGen = "INSERT INTO `genre` (`nameGenre`) VALUES ('$nameGen')";
    $sqlGenDo = $db->prepare($sqlGen);
    if($sqlGenDo->execute()){
        echo '<script language= "JavaScript">
location.href="adminPage.php";
alert("Inserção realizada!");
</script>';
    }else{
        echo '<script language= "JavaScript">
location.href="adminPage.php";
alert("Erro na inserção do gênero!");
</script>';
    }
}

//inserção de artista no bd
if(!empty($_POST['subArt'])){
    if(!empty($_POST['nameArt']) and !empty($_FILES['photoArt']) and !empty($_POST['bioArt']) and !empty($_POST['countryArt'])){
        include './conexao.php';
        $nameArt= $_POST['nameArt'];
        $photoArt = $_FILES['photoArt'];
        $bioArt = $_POST['bioArt'];
        $countryArt = $_POST['countryArt'];
        //tratamento da foto
        $error = array();
if (!preg_match("/^image\/(jpg|jpeg|png|gif)$/", $photoArt["type"])) {
    $error[1] = "Você deve enviar uma imagem.";
}
if (count($error) == 0) {
    preg_match("/\.(gif|png|jpg|jpeg){1}$/i", $photoArt["name"], $ext);
    $photoArtFile = md5(uniqid(time())) . "." . $ext[1];
    $photoArtPath = "photos/artists/" . $photoArtFile;
    $sqlArt = "INSERT INTO artist (nameArtist,photoArtist,bioArtist,idCountry) VALUES "
            . "('$nameArt','$photoArtFile','$bioArt','$countryArt')";
    $sqlArtDo = $db->prepare($sqlArt);
    if($sqlArtDo->execute()){
    move_uploaded_file($photoArt["tmp_name"], $photoArtPath);
        //header("location: adminPage.php");
    }else{
        echo '<script language= "JavaScript">
location.href="adminPage.php";
alert("Erro na inserção do artista!");
</script>';
    }
    
}
 if (count($error) != 0) {
    foreach ($error as $erro) {
        echo "<script language= 'JavaScript'>
alert('$erro');
</script>";
    }
 }   
    }else{
        echo '<script language= "JavaScript">
location.href="adminPage.php";
alert("Preencha todos os campos!");
</script>';
    }
}

// inserção de album no bd
if(!empty($_POST['subAlb'])){
    if(!empty($_POST['nameAlb']) and !empty($_FILES['photoAlb']) and !empty($_POST['typeAlb']) and !empty($_POST['AlbArt1'])){
        include './conexao.php';
        $artistas = array();
        
        //adiciona possiveis artistas
        if($_POST["AlbArt1"] == 'null'){
            echo '<script language= "JavaScript">
location.href="adminPage.php";
alert("O álbum deve ter seu primeiro artista preenchido!");
</script>';
        }else{
        $co = $_POST['co'];
        $whileI = 0;
        while($whileI<$co){
            $wii= $whileI+1;
            if(!empty($_POST["AlbArt$wii"]) and $_POST["AlbArt$wii"] != 'null'){
            $artistas[] = $_POST["AlbArt$wii"];
            }
            $whileI++;
        }
        
        $nameAlb = $_POST['nameAlb'];
        $photoAlb = $_FILES['photoAlb'];
        $typeAlb = $_POST['typeAlb'];
        
        //tratamento da foto
        $error = array();
if (!preg_match("/^image\/(jpg|jpeg|png|gif)$/", $photoAlb["type"])) {
    $error[1] = "Você deve enviar uma imagem.";
}
if (count($error) == 0) {
    preg_match("/\.(gif|png|jpg|jpeg){1}$/i", $photoAlb["name"], $ext);
    $photoAlbFile = md5(uniqid(time())) . "." . $ext[1];
    $photoAlbPath = "photos/albuns/" . $photoAlbFile;
    $sqlAlb = "INSERT INTO album (nameAlbum,photoAlbum,typeAlbum) VALUES "
            . "('$nameAlb','$photoAlbFile','$typeAlb')";
    $sqlAlbDo = $db->prepare($sqlAlb);
    if($sqlAlbDo->execute()){
    move_uploaded_file($photoAlb["tmp_name"], $photoAlbPath);
    $lastID = $db->lastInsertId();
    $sizeArray = count($artistas);
    $i = 0;
    while($i<$sizeArray){
    $art = $artistas[$i];
    $sqlAlbArt = "INSERT INTO albumartist (idAlbum,idArtist) VALUES"
            . "('$lastID','$art')";
    $sqlAlbArtDo = $db->prepare($sqlAlbArt);
    if($sqlAlbArtDo->execute()){
        echo '<script language= "JavaScript">
location.href="adminPage.php";
alert("Inserção realizada!");
</script>';
    }
    $i++;
    }
    }else{
        echo '<script language= "JavaScript">
location.href="adminPage.php";
alert("Erro na inserção do álbum!");
</script>';
    }
    
}
 if (count($error) != 0) {
    foreach ($error as $erro) {
        echo "<script language= 'JavaScript'>
alert('$erro');
</script>";
    }
 }   
    }    
    }else{
        echo '<script language= "JavaScript">
location.href="adminPage.php";
alert("Preencha todos os campos!");
</script>';
    }
}

//inserção de músicas em um álbum
if(!empty($_POST['subMusic'])){
    if(!empty($_POST['album']) and !empty($_POST['nameMusic1']) and !empty($_FILES['fileMusic1'])){
       $idAlbum = $_POST['album'];
       $c =  $_POST['c'];
       if(empty($_POST['cg'])){
          echo '<script language= "JavaScript">
location.href="adminPage.php";
alert("As músicas precisam de gêneros!");
</script>'; 
       }else{
          $cg = $_POST['cg'];
       }
       if(empty($_POST['co'])){
            echo '<script language= "JavaScript">
location.href="adminPage.php";
alert("Erro, clique no mais!");
</script>';
        }else{
       $co = $_POST['co'];
        
       $i=0;
       while ($i<$c){
           
           $ii = $i+1;
           
           $whileI = 0;
        while($whileI<$co){
            $wii= $whileI+1;
            if(!empty($_POST["two$ii"."AlbArt$wii"]) and $_POST["two$ii"."AlbArt$wii"] != 'null'){
            $artistas[] = $_POST["two$ii"."AlbArt$wii"];
            }else{
                $artistas = 'null';
            }
            $whileI++;
        }
        $whileJ = 0;
        while($whileJ<$cg){
            $wjj= $whileJ+1;
            if(!empty($_POST["twog$ii"."MusGen$wjj"]) and $_POST["twog$ii"."MusGen$wjj"] != 'null'){
            $genres[] = $_POST["twog$ii"."MusGen$wjj"];
            }else{
                $genres = 'null';
            }
            $whileJ++;
        }
           
           $nameMusic = str_replace("'", "***", $_POST['nameMusic'.$ii]);
           $fileMusic = $_FILES['fileMusic'.$ii];
           
           $featMusic = $artistas;
           $error = array();
if ($fileMusic["type"] !== "audio/mp3") {
    $error[1] = "Você deve enviar um áudio em mp3.";
}
if (count($error) == 0) {
    $ext = "mp3";
    $fileMusicFile = md5(uniqid(time())) . "." . $ext;
    $fileMusicPath = "musics/" . $fileMusicFile;
    $sqlMus = "INSERT INTO music (nameMusic,fileMusic,idAlbum) VALUES "
            . "('$nameMusic','$fileMusicFile',$idAlbum)";
    $sqlMusDo = $db->prepare($sqlMus);
    if($sqlMusDo->execute()){
    move_uploaded_file($fileMusic["tmp_name"], $fileMusicPath);
    $sqlArtMus1 = "SELECT idArtist FROM albumartist WHERE idAlbum = $idAlbum";
    $sqlArtMus1Do = $db->prepare($sqlArtMus1);
    $lastID = $db->lastInsertId();
    $sqlArtMus1Do->execute();
    if($sqlArtMus1Do->rowcount() > 0){
                    while ($rs = $sqlArtMus1Do->fetch(PDO::FETCH_OBJ)){
                       $sqlArtMus2 = "INSERT INTO `musicartist`(`idMusic`, `idArtist`) VALUES ($lastID,$rs->idArtist)";
                       $sqlArtMus2Do = $db->prepare($sqlArtMus2);
                       if($sqlArtMus2Do->execute()){
                           
                           if($artistas !== 'null'){
                           $it = 0;
                           $sizze = count($featMusic);
                           while ($it<$sizze){
                           $sqlLastInsert = "INSERT INTO `musicartist`(`idMusic`, `idArtist`) VALUES ($lastID,$featMusic[$it])";
                           $sqlFdo = $db->prepare($sqlLastInsert);
                           
                           if($sqlFdo->execute()){
                               
                               if($genres !== 'null'){
                           $jt = 0;
                           $sizzee = count($genres);
                           while ($jt<$sizzee){
                           $sqlLastInsert = "INSERT INTO `musicgenre`(`idMusic`, `idGenre`) VALUES ($lastID,$genres[$jt])";
                           $sqlFdo = $db->prepare($sqlLastInsert);
                           
                           if($sqlFdo->execute()){
                               
                               echo '<script language= "JavaScript">
location.href="adminPage.php";
alert("Deu tudo certo!");
</script>';
                           }else{
                               echo '<script language= "JavaScript">
location.href="adminPage.php";
alert("Erro ao ligar música ao genero!");
</script>';
                           }
                           
                           $jt++;
                           }
                           }
                           }else{
                               echo '<script language= "JavaScript">
location.href="adminPage.php";
alert("Erro ao ligar música aos artistas adicionais!");
</script>';
                           }
                           
                           
                           $it++;
                           }
                           }else{
                               
                                if($genres !== 'null'){
                           $jt = 0;
                           $sizzee = count($genres);
                           while ($jt<$sizzee){
                           $sqlLastInsert = "INSERT INTO `musicgenre`(`idMusic`, `idGenre`) VALUES ($lastID,$genres[$jt])";
                           $sqlFdo = $db->prepare($sqlLastInsert);
                           
                           if($sqlFdo->execute()){
                               
                               echo '<script language= "JavaScript">
location.href="adminPage.php";
alert("Deu tudo certo!");
</script>';
                           }else{
                               echo '<script language= "JavaScript">
location.href="adminPage.php";
alert("Erro ao ligar música ao genero!");
</script>';
                           }
                           
                           $jt++;
                           }
                           }
                           unset($genres);
                               echo '<script language= "JavaScript">
location.href="adminPage.php";
alert("Inserção realizada!");
</script>';
                               
                           }
                           
                       }else{
                           echo '<script language= "JavaScript">
location.href="adminPage.php";
alert("Deu erro ao ligar música e artista do álbum!");
</script>';
                       }
                    }
                }
                //até aqui
                unset($genres);
                           unset($artistas);
                           unset($featMusic);
    }else{
        echo '<script language= "JavaScript">
location.href="adminPage.php";
alert("FDeu erro na inserção da música!'.$fileMusicFile.'");
</script>';
    }
    
}
 if (count($error) != 0) {
    foreach ($error as $erro) {
        echo "<script language= 'JavaScript'>
alert('$erro');
</script>";
    }
 }           
           $i++;
       }
        }
    }else{
            echo '<script language= "JavaScript">
location.href="adminPage.php";
alert("Faltou preencher todos os campos!");
</script>';
    }
}
?>