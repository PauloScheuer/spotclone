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
            echo "<option value='null'>Nenhum</option>";
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
                ?></select>";
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
    if(!empty($_POST['album'])){
    include './conexao.php';
    //definição das variáveis necessárias
    $album = $_POST['album']; // album onde vão ser inseridas as músicas
    $names = array(); //array contendo o nome das músicas
    $files = array(); //array contendo os arquivos das músicas
    $artists = array(); // array(que conterá outros arrays) com os artistas extras
    $initArtists = array(); //array(que conterá outros arrays) com os artistas do álbum
    $genres = array(); // array(que conterá outros arrays) com os gêneros
    $numMusic = $_POST['c']; //número de músicas sendo inseridas na execução
    $error = array(); // array com os possíveis erros na execução
    $values = "";//variável contendo todos os valores das músicas
    $valuesG = ""; //variável contendo todos os valores da tabela musicgenre
    $valuesA = ""; //variável contendo todos os valores da tabela musicartist
    $multipleID = array(); //array contendo os IDS inseridos
    
    //repetição que preencherá os arrays
    $iGeneral = 0;
    while ($iGeneral<$numMusic){
        $ii = $iGeneral+1;
        if( !empty($_POST["nameMusic$ii"]) and !empty($_FILES["fileMusic$ii"]) ){
        $thisName =  str_replace("'", "***", $_POST["nameMusic$ii"]);
        $names[] =  str_replace('"', "###", $thisName);
        $files[] = $_FILES["fileMusic$ii"];
        
        //tratamento do arquivo de som
        if ($files[$iGeneral]["type"] !== "audio/mp3" and $files[$iGeneral]["type"] !== "audio/mpeg") {
        $error[] = "Você deve enviar um áudio em mp3.".$files[$iGeneral]["type"];
        }else{
        $ext = "mp3";
        $files[$iGeneral][0] = md5(uniqid(time())) . "." . $ext;
        $files[$iGeneral][1] = "musics/" . $files[$iGeneral][0];
        
        //preenchimento dos valores que irão dentro da tabela música
        
        if($iGeneral == 0){
        $values.= "('".$names[$iGeneral]."','".$files[$iGeneral][0]."',".$album.")";   
        }else{
        $values.= ",('".$names[$iGeneral]."','".$files[$iGeneral][0]."',".$album.")";   
        } 
        
        //preenchimento dos valores que irão na tabela musicgenre

        $genres[$ii] = array();
        $iGenre = 1;
        while($iGenre<=3){
            if(!empty($_POST['twog'.$ii.'MusGen'.$iGenre]) and $_POST['twog'.$ii.'MusGen'.$iGenre] != 'null'){
        $genres[$ii][] = $_POST['twog'.$ii.'MusGen'.$iGenre]; 
            }
        $iGenre++;
        }
        
        
        //preenchimento dos valores que irão na tabela musicartist
        $artists[$ii] = array();
        //primeira etapa, artistas do álbum
        $sqlgetArt = "SELECT idArtist from albumartist WHERE idAlbum = $album";// obter artistas do álbum que a música pertence
            $sqlgetArtdo = $db->prepare($sqlgetArt);
            $sqlgetArtdo->execute();
            if($sqlgetArtdo->rowcount()>0){
                while ($rs = $sqlgetArtdo->fetch(PDO::FETCH_OBJ)){
                  $artists[$ii][] = $rs->idArtist;  
                }
            }
        //segunda etapa, artistas extras:
        $iArt = 1;
        while($iArt<=30){
            if(!empty($_POST['two'.$ii.'AlbArt'.$iArt]) and $_POST['two'.$ii.'AlbArt'.$iArt] != 'null'){
        $artists[$ii][] = $_POST['two'.$ii.'AlbArt'.$iArt]; 
            }
        $iArt++;
        }
        
        }
        
        }else{
            $error[] = "Você deve preencher todos os campos de nomes/arquivos de todas as músicas"; 
        }
        if(empty($genres[$ii])){
            $error[] = "Cada música deve ter ao menos um gênero";
        }
        $iGeneral++;
    }
    if(empty($error)){
    $sqlMus = "INSERT INTO `music`(`nameMusic`, `fileMusic`, `idAlbum`) VALUES $values;";
    $sqlMusDo = $db->prepare($sqlMus);
    $sqlMusDo->execute(); //execução da inserção na tabela music
    if($sqlMusDo->rowcount()>0){
        //upload das músicas no servidor
        $iUpload = 0;
        while ($iUpload<$numMusic){
        move_uploaded_file($files[$iUpload]["tmp_name"], $files[$iUpload][1]);
        $iUpload++;
        }
        //obtenção dos ids inseridos
        $firstID = $db->lastInsertId();
        $iID = 0;
        while ($iID<$numMusic){
            $multipleID[] = $firstID+$iID;
            $iID++;
        }
        //preenchimento da variável valuesG
        $ivg = 0; //variavel values-genres
        while ($ivg<$numMusic){
            $jvg = 0;//variavel values-genres secundária
            while ($jvg<3){
            if(!empty($genres[$ivg+1][$jvg])){
            if($ivg == 0 and $jvg==0){
            $valuesG .= "($multipleID[$ivg],".$genres[$ivg+1][$jvg].")";
            
            }else{
            $valuesG .= ",($multipleID[$ivg],".$genres[$ivg+1][$jvg].")";    
            }
            }
            $jvg++;
            }
            $ivg++;
        }
        //preenchimento da variável valuesA
        $iva = 0; //variavel values-artists
        while ($iva<$numMusic){
            $jva = 0;//variavel values-artists secundária
            while ($jva<=30){
            if(!empty($artists[$iva+1][$jva])){
            if($iva == 0 and $jva==0){
            $valuesA .= "($multipleID[$iva],".$artists[$iva+1][$jva].")";
            
            }else{
            $valuesA .= ",($multipleID[$iva],".$artists[$iva+1][$jva].")";    
            }
            }
            $jva++;
            }
            $iva++;
        }
        $sqlmusgen = "INSERT INTO `musicgenre`(`idMusic`, `idGenre`) VALUES $valuesG"; //sql inserção musicgenre
        $sqlmusgendo = $db->prepare($sqlmusgen);
        $sqlmusgendo->execute();
        if($sqlmusgendo->rowcount()>0){
          $sqlmusart = "INSERT INTO `musicartist`(`idMusic`, `idArtist`) VALUES $valuesA"; //sql inserção musicartist
          $sqlmusartdo = $db->prepare($sqlmusart);
          $sqlmusartdo->execute();
          if($sqlmusartdo->rowcount()>0){
              echo "<script language= 'JavaScript'>
                    alert('Inserção realizada com sucesso!');
                    location.href = 'adminPage.php';
                    </script>";
                
          }else{
              echo "<script language= 'JavaScript'>
                    alert('Música inserida, mas ouve um problema no relacionamento dela com seus artistas, fav
                    or entrar em contato');
                    location.href = 'adminPage.php';
                    </script>";
          }
        }else{
            echo "<script language= 'JavaScript'>
                    alert('Música inserida, mas ouve um problema no relacionamento dela com seus gêneros, fav
                    or entrar em contato');
                    location.href = 'adminPage.php';
                    </script>";
        }
    }else{
        echo "<script language= 'JavaScript'>
                    alert('Música não inserida :(');
                    location.href = 'adminPage.php';
                    </script>";
    }
    }else{
        if (count($error) != 0) {
        foreach ($error as $erro) {
        echo "<script language= 'JavaScript'>
        alert('$erro');
        location.href = 'adminPage.php';
        </script>";
    }
    }
    }
    }
}