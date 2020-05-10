window.onload = initPage;
//função para iniciar a pagina corretamente
function initPage() {
    sessionStorage.setItem('page', 1);
    //mantém o content ao atualizar a pagina
    if(sessionStorage.getItem('content') != null){
        var content = sessionStorage.getItem('content');
        $('#content').load(content).hide().fadeIn('slow');
    }else{
        $('#content').load('./listMusic.php?search=').hide().fadeIn('slow');
    }
    //mantém o player ao atualizar a página
    if (sessionStorage.getItem('audioHTML') != null) {
        var $DinSelect = document.querySelector("#player");
        audioHTML = sessionStorage.getItem('audioHTML');
        $DinSelect.innerHTML = audioHTML;
        //mantém o shuffleset (que fica dentro do player)
        if(sessionStorage.getItem('shuffleset') != "undefined"){
            var set =  sessionStorage.getItem('shuffleset');
            if(set == 'true'){
            document.getElementById("shuffleOff").style.display = "none";
            document.getElementById("shuffleOn").style.display = "block";
            }else{
            document.getElementById("shuffleOff").style.display = "block";
            document.getElementById("shuffleOn").style.display = "none"; 
            }
            }else{
            document.getElementById("shuffleOff").style.display = "block";
            document.getElementById("shuffleOn").style.display = "none";   
            }
    }
    //mantém o titulo ao atualizar a página
    if (sessionStorage.getItem('title') != null) {
        document.title = sessionStorage.getItem('title');
    }
    //mantém o tempo corrente da música ao atualizar a página
    if (sessionStorage.getItem('current') != null) {
        currentTime = sessionStorage.getItem('current');
        if (sessionStorage.getItem('music') != null) {
            currentAudioId = sessionStorage.getItem('music');
            currentAudio = document.getElementById(currentAudioId);
            currentAudio.currentTime = currentTime;
            control = 0;
            ableToPlay = true;
            tocar(currentAudioId, false);

        }
    }

}
//formulario de pesquisa
$(document).ready(function () {
    $('#search').ajaxForm(function () {

        var search = $('#name').val();
        var type = $("input[name='typeSearch']:checked").val();
        if (type == "music") {
            var href = "listMusic.php";
        } else if (type == "album") {
            var href = "listAlbum.php";
        } else {
            location.href = "index.php";
            alert('Erro na pesquisa');
        }
        searchClean = search.replace(/\s/g, '+');
        var content = href+"?search="+searchClean;
        sessionStorage.setItem('content',content);
        $('#content').load(content).hide().fadeIn('slow');
        sessionStorage.setItem('page', 1);

    });
});
//função que carrega mais musicas/albuns
function loadmore(search, href) {
    if (sessionStorage.getItem('page') != null) {
        var page = parseInt(sessionStorage.getItem('page')) + parseInt(1);
    } else {
        var page = 2;
    }
    sessionStorage.setItem('page', page);
    var content = href+"?search="+search+"&page="+page+"";
    sessionStorage.setItem('content',content);
    $('#content').load(content).hide().fadeIn('slow');
}



var control = 1; //controle entre pausado e tocando
ableSkip = false;// variavel que permite o skip em casos de atualização da pagina

//função principal do player, "mãe" de todas as outras e que cria o ambiente da música, chamando outras funções
function tocar(id,newpl,pl,type){
     getData(id).then(function() {
     if (sessionStorage.getItem('music') != null){
        audioBefID = sessionStorage.getItem('music');
        if(audioBefID != id){
            create(id,newpl,pl,type);
         if(typeof(frT) != "undefined"){ 
         clearInterval(frT);
         }
         if(typeof(fr) != "undefined"){ 
         clearInterval(fr);
         }
         if(typeof(frD) != "undefined"){ 
         clearInterval(frD);
         }
         
        if(document.getElementById("imgPlayCard"+audioBefID) != null){
        document.getElementById("imgPlayCard"+audioBefID).src = "icons/play.svg";
        }
        
        audioBef = document.getElementById(audioBefID);
        audioBef.src = '';
        audioBefDiv = document.getElementById("div"+audioBefID);
        audioBefDiv.remove();
        control = 1;
        setControl = false;
        }else{
        if(typeof(pl) != "undefined" && typeof(type) != "undefined"){
            if(pl != sessionStorage.getItem('idpl') && type != sessionStorage.getItem('idpl')){
            create(id,newpl,pl,type);
            stopMusic(id);
            control = 1;
            setControl = false;
            }
            }
        } 
    }else{
     create(id,newpl,pl,type);
    }    
    if(control===1){
            if ( $( "#"+id+"" ).length != 0) { 
            /* elemento existe */ 
            }else{
            var nameR = name.replace("***", "'");
            nameSearch = document.getElementById("name"+id);
            if(sessionStorage.getItem('shuffleset') != "undefined"){
            var set =  sessionStorage.getItem('shuffleset');
            if(set == 'true'){
            var displayOff ="style='display:none'";
            var displayOn ="style='display:block'";
            }else{
            var displayOff ="style='display:block'";
            var displayOn ="style='display:none'";    
            }
            }else{
            var displayOff ="style='display:block'";
            var displayOn ="style='display:none'";    
            }
            var $DinSelect = document.querySelector("#player"),
            HTMLTemp = $DinSelect.innerHTML,
            HTMLNew =   "<div id='div"+id+"' class='inside'>\n\
                        <audio id='"+id+"' src='musics/"+file+"'></audio>\n\
                        <img src='photos/albuns/"+photo+"' class='playerPhoto'>\n\
                        <h3 id='name'>"+nameR+"</h3>\n\
                        <section id='plbuttons'>\n\
                        <div id='plup'>\n\
                        <a onclick='back(30)' class='playerButton' id='back'><img src='icons/chevrons-left.svg'></a>\n\
                        <a onclick='playMusic(0)' class='playerButton' id='playB'><img src='icons/play-circle.svg'></a>\n\
                        <a onclick='pauseMusic(0)' class='playerButton' id='pauseB' style='display:none'><img src='icons/pause-circle.svg'></a>\n\
                        <a onclick='stopMusic(0)' class='playerButton'><img src='icons/stop-circle.svg'></a>\n\
                        <a onclick='skip(30)' class='playerButton' id='skip'><img src='icons/chevrons-right.svg'></a>\n\
                        <a onclick='shuffleSet(true)' class='playerButton' id='shuffleOff' "+displayOff+"><img src='icons/shuffleOff.svg'></a>\n\
                        <a onclick='shuffleSet(false)' class='playerButton' id='shuffleOn' "+displayOn+"><img src='icons/shuffleOn.svg'></a>\n\
                        </div>\n\
                        <section id='pldown'>\n\
                        <a onclick='anteriorMusic()' class='playerButton'><img src='icons/skip-back.svg'></a>\n\
                        <div id='progress' onclick='barFunction()'>\n\
                        <div id='bar' ></div>\n\
                        </div>\n\
                        <a onclick='nextMusic()' class='playerButton'><img src='icons/skip-forward.svg'></a>\n\
                        </section>\n\
                        </section>\n\
                        <h2 id='time'></h2>\n\
                        </div>";
            HTMLTemp =  HTMLTemp + HTMLNew;
            $DinSelect.innerHTML = HTMLTemp;
            sessionStorage.setItem('audioHTML', HTMLTemp);
            titleD = "Spotclone - "+nameR;
            document.title = titleD;
            sessionStorage.setItem('title', titleD);
        }
       playMusic(id);
    }else{
       pauseMusic(id);
       if(typeof(ableToPlay) != "undefined"){
       if(ableToPlay != null && ableToPlay == true){
         control = 1;  
       }
   }
    }
    }); 
}
//função que toca a música
function playMusic(id){
    if(id == 0){
    if(sessionStorage.getItem('music') != null){
    var sessionID = sessionStorage.getItem('music');
    audio = document.getElementById(sessionID);  
    sessionStorage.setItem('music', sessionID);
    curTim = sessionID;
        }else{
            alert("não deu");
        }
    }else{
    audio = document.getElementById(id);
    sessionStorage.setItem('music', id);
    curTim = id;
    }
    var playPromise = audio.play();
 
  if (playPromise !== undefined) {
    playPromise.then(function() {
        
        audio.onloadeddata = function(){
            let data = new Date(null);
    data.setSeconds(audio.duration);
    let duracao = data.toISOString().substr(14,5);
    time = document.getElementById("time");
    time.innerHTML = duracao;
    var $DinSelect = document.querySelector("#player");
    var HTMLTemp = $DinSelect.innerHTML;
    sessionStorage.setItem('audioHTML', HTMLTemp);
    };
    
    
    })
    .catch(error => {
    });
  }
   //trecho do código que só permite setar os fr's se é a primeira música ou
   //é uma musica diferente da anterior, evitando bug que mostrava
   //simbolo de tocando em duas musicas ao mesmo tempo. 
   if(typeof(setControl) == "undefined"){
    timer(curTim);
    move(curTim);
    detect(curTim);
    }else if(typeof(setControl) != "undefined" && setControl == false){
      timer(curTim);
    move(curTim);
    detect(curTim);  
    }
}
//função que pausa a música
function pauseMusic(id){
    if(id == 0){
        if(sessionStorage.getItem('music') != null){
    var sessionID = sessionStorage.getItem('music');
    audio = document.getElementById(sessionID);
        }else{
            alert("não deu");
        }
        }else{
    audio = document.getElementById(id);
    }
    
    audio.pause();
}
//função que pausa a música e a retorna ao inicio
function stopMusic(id){
    if(id == 0){
        if(sessionStorage.getItem('music') != null){
    var sessionID = sessionStorage.getItem('music');
    var audio = document.getElementById(sessionID); 
        }else{
            alert("não deu");
        }
    }else{
    var audio = document.getElementById(id);
    }
    audio.pause();
    audio.currentTime = 0;
    var elem = document.getElementById("bar");
    elem.style.width = 0 + "%";
    var data = new Date(null);
    data.setSeconds(audio.duration);
    if(data != 'Invalid Date'){
    var duracao = data.toISOString().substr(14, 5);
    var timer = document.getElementById("time");
    timer.innerHTML = duracao;
    sessionStorage.setItem('current',0);
    }
}
//função que movimenta a barra de progresso da musica
function move(id) {
    var elem = document.getElementById("bar");
    audio = document.getElementById(id);
    width = 0;
    fr = setInterval(frame, 100);
    function frame() {
        tempo = audio.currentTime; 
        duration = audio.duration; 
      if (width >= 100) {
        elem.style.width = 0 + "%";
        clearInterval(fr);
      } else {
        width= (tempo*100)/duration;
        elem.style.width = width + "%";
      }
    }
}
//função que conta o tempo da musica, mostrando o restante
function timer(id){
    var timer = document.getElementById("time");
    audio = document.getElementById(id);
    frT = setInterval(frameT, 100);
    function frameT() {
        tempo = audio.currentTime;
        duration = audio.duration;
        toComeTime = (duration) - (tempo) ;
      if (toComeTime == 0) {
        clearInterval(frT);
      } else {
        data = new Date(null);
        data.setSeconds(toComeTime);
        if(data != 'Invalid Date'){
        duracao = data.toISOString().substr(14, 5);
        timer.innerHTML = duracao;
        sessionStorage.setItem('current',tempo);
        
    }else{
        timer.innerHTML = "<img src='icons/loading.gif' style='width: 50px; height: 50px'>";
    }
      }
    }
}
//função para detectar se a musica tá tocando(a variavel control não resolve completamente,
//pois é possivel tocar a musica pelo proprio sistema operacional)
function detect(id){
    frD = setInterval(frameD, 100);
    function frameD(){
        var audioC = document.getElementById(id);
        if (audioC != null){
        var duration = audioC.duration;
        var current = audioC.currentTime;
        if(current == duration){
            stopMusic(id);
            nextMusic();
        }
    }
     if(audio.paused== false){
        control = 0;
        if(document.getElementById("imgPlayCard"+id) != null){
        document.getElementById("imgPlayCard"+id).src = "icons/pause.svg";
        }
        document.getElementById("playB").style.display= "none";
        document.getElementById("pauseB").style.display= "block";
        }else{
        setControl = true;    
        control = 1;
        sessionStorage.setItem('control',1);
        if(document.getElementById("imgPlayCard"+id) != null){
        document.getElementById("imgPlayCard"+id).src = "icons/play.svg";
        }
        document.getElementById("pauseB").style.display= "none";
        document.getElementById("playB").style.display= "block";
        if(ableSkip == false){
        clearInterval(fr);
        clearInterval(frT);
        }
        }  
    }
}
//função futura para selecionar tempo da musica pela barra de progresso
function barFunction(){
    alert("função em desenvolvimento");
}
//função que pula a musica para frente
function skip(sec){
    var id = sessionStorage.getItem('music');
    var audio = document.getElementById(id);
    var bynowtime = audio.currentTime;
    audio.currentTime = bynowtime+sec;
    move(id);
    timer(id);
    ableSkip = true;
}
//função que volta a musica
function back(sec){
    var id = sessionStorage.getItem('music');
    var audio = document.getElementById(id);
    bynowtime = audio.currentTime;
    audio.currentTime = bynowtime-sec;
    move(id);
    timer(id);
    ableSkip = true;
}
//função que toca a proxima musica da playlist
function nextMusic(){
    if (sessionStorage.getItem('playlist') != null) {
        if (sessionStorage.getItem('shuffleset') == null || sessionStorage.getItem('shuffleset') == 'false') {
            var playlist = sessionStorage.getItem('playlist').split(",");
            if (playlist.length != 1) {
                if (sessionStorage.getItem('nowMusic') != null && sessionStorage.getItem('nowMusic') != (playlist.length - 1)) {
                    if(sessionStorage.getItem('init') == 'false'){
                    if(sessionStorage.getItem('typelast') == 'random'){
                    var playlistR = sessionStorage.getItem('playlistRandom').split(",");
                    var indexNow = sessionStorage.getItem('nowMusicR');
                    var idNow = playlistR[indexNow];
                    var now = playlist.indexOf(idNow);
                    if(now+1 != playlistR.length ){
                    var nextPosition = parseInt(now) + parseInt(1);
                    }else{
                    var nextPosition = 0;  
                    }
                    console.log(sessionStorage.getItem('typelast'));
                    }else{
                    var now = sessionStorage.getItem('nowMusic');  
                    var nextPosition = parseInt(now) + parseInt(1);
                    }
                }else{
                  var now = sessionStorage.getItem('nowMusic');  
                  var nextPosition = parseInt(now) + parseInt(1);  
                }
                } else {
                    var nextPosition = 0;
                }
                var playlistRandom = JSON.parse(JSON.stringify(playlist));
                treatRandom(playlistRandom, playlist[nextPosition]);
                sessionStorage.setItem('playlistRandom', playlistRandom);
                console.log(playlistRandom);
                sessionStorage.setItem('nowMusic', nextPosition);
                tocar(playlist[nextPosition], 'false');
                sessionStorage.setItem('typelast', 'normal');
                sessionStorage.setItem('init',false);
            }
        } else if(sessionStorage.getItem('shuffleset') == 'true') {
            var playlist = sessionStorage.getItem('playlistRandom').split(",");
            if (playlist.length != 1) {
                if (sessionStorage.getItem('nowMusicR') != null && sessionStorage.getItem('nowMusicR') != (playlist.length - 1)) {
                    if(sessionStorage.getItem('init') == 'false'){
                    if(sessionStorage.getItem('typelast') == 'normal'){
                     var nextPosition = 1;   
                    }else{
                     var actualPosition = sessionStorage.getItem('nowMusicR');
                     var nextPosition = parseInt(actualPosition) + parseInt(1);   
                    }
                    }else{
                     var now = sessionStorage.getItem('nowMusicR');  
                     var nextPosition = parseInt(now) + parseInt(1); 
                    }
                } else {
                    if(sessionStorage.getItem('typelast') == 'random'){
                    var nextPosition = 0;
                }else{
                   var nextPosition = 1; 
                }
                }
                tocar(playlist[nextPosition], 'false');
                sessionStorage.setItem('nowMusicR', nextPosition);
                sessionStorage.setItem('typelast', 'random');
                sessionStorage.setItem('init',false);
            }    
        }
    }
}
//função que toca a musica anterior da playlist
function anteriorMusic(){
    if(sessionStorage.getItem('playlist') != null && sessionStorage.getItem('playlistRandom') != null){
        var playlist = sessionStorage.getItem('playlist').split(",");
        var playlistRandom = sessionStorage.getItem('playlistRandom').split(",");
   if(sessionStorage.getItem('shuffleset') == 'true'){
       if(sessionStorage.getItem('nowMusicR') != null && sessionStorage.getItem('nowMusicR') != (0)){
       if(sessionStorage.getItem('typelast') != 'normal'){
                    var actualPosition = sessionStorage.getItem('nowMusicR');
                    var nextPosition = parseInt(actualPosition) - parseInt(1);
                    tocar(playlistRandom[nextPosition], 'false');
                    sessionStorage.setItem('nowMusicR', nextPosition);
       }
   }
   
   }else{
    if(sessionStorage.getItem('nowMusic') != null && sessionStorage.getItem('nowMusic') != (0)){
       if(sessionStorage.getItem('typelast') != 'random'){
                    var actualPosition = sessionStorage.getItem('nowMusic');
                    var nextPosition = parseInt(actualPosition) - parseInt(1);
                    tocar(playlist[nextPosition], 'false');
                    var playlistRandom = JSON.parse(JSON.stringify(playlist));
                    treatRandom(playlistRandom, playlist[nextPosition]);
                    sessionStorage.setItem('playlistRandom', playlistRandom);
                    console.log(playlistRandom);
                    sessionStorage.setItem('nowMusic', nextPosition); 
       }
   } 
   }
    }
}
//função que ativa e desativa shuffle
function shuffleSet(bool){
    var bool = bool;
    if (bool === true) {
        document.getElementById("shuffleOff").style.display = "none";
        document.getElementById("shuffleOn").style.display = "block";
        console.log("shuffle ativado");
        sessionStorage.setItem('shuffleset',true);
    } else {
        document.getElementById("shuffleOff").style.display = "block";
        document.getElementById("shuffleOn").style.display = "none";
        console.log("shuffle desativado");
        sessionStorage.setItem('shuffleset',false);
    }
}

//função que obtem os valores necessarios para criar o player(foto, nome, arquivo da musica)
async function getData(id){
    await $.ajax({
    url: 'data.php', 
    dataType: 'json',
    type: 'post', 
    data: { id: id },
 
   success: function(result){
            var dataID = result;
            file = dataID[0];
            name = dataID[1];
            photo = dataID[2];
            
        },
    error: function(){
           alert('Ouve um erro na execução da música'); 
    }
});
}
//função que cria a playlist, através de um array com os IDs
async function getID(pl,typer){
   await $.ajax({
    url: 'getID.php', 
    dataType: 'json',
    type: 'post', 
    data: { pl: pl,
            typer: typer},
 
   success: function(result){
            var playlist = result;
            sessionStorage.setItem('playlist',playlist);  
        },
    error: function(){
           alert('Ouve um erro na criação da playlist'); 
    }
}); 
}
function create(id,newpl,pl,type){
    if(newpl == true){
        sessionStorage.setItem('nowMusic',0);
        sessionStorage.setItem('nowMusicR',0);
        getID(pl,type).then(function() {
        var playlist = sessionStorage.getItem('playlist').split(","); 
        var playlistRandom = JSON.parse(JSON.stringify(playlist));
        treat(playlist,id);
        treatRandom(playlistRandom,id);
        console.log(playlist);
        console.log(playlistRandom);
        sessionStorage.setItem('playlist',playlist);
        sessionStorage.setItem('playlistRandom',playlistRandom);
        sessionStorage.setItem('idpl',pl);
        sessionStorage.setItem('type',type);
        sessionStorage.setItem('init',true);
    });
    }
}
//função retirada do StackOverflow que embaralha o array
function shuffle(array) {
  var m = array.length, t, i;

  // While there remain elements to shuffle…
  while (m) {

    // Pick a remaining element…
    i = Math.floor(Math.random() * m--);

    // And swap it with the current element.
    t = array[m];
    array[m] = array[i];
    array[i] = t;
  }

  return array;
}
//função que faz o tratamento da playlist em ordem normal
function treat(array,id){
            var numString = id.toString();
            var VIP = array.indexOf(numString);
            var size = array.length;
            var cloneArray = JSON.parse(JSON.stringify(array));
            var i = 0;
            while (i<size){
                var place = parseInt(VIP) + parseInt(i);
                if(place < size ){
                var VIPplace = place;
                }else{
                var VIPplace = place-size;
                }
                array[i] = cloneArray[VIPplace];
                i++;
            }
        }
//função que embaralha playlist e faz o tratamento dela        
function treatRandom(playlist,id){
                shuffle(playlist);
                var firstID = playlist[0];
                var numString = id.toString();
                var VIP = playlist.indexOf(numString);
                playlist[VIP] = firstID;
                playlist[0] = id;
        } 
//função que abre um álbum
function openAlbum(idAlbum){
   $("#content").load("page.php?id="+idAlbum+"&type=alb");
   sessionStorage.setItem("content","page.php?id="+idAlbum+"&type=alb");
}