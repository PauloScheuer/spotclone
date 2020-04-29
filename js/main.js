var control = 1;
ableSkip = false;
function tocar(id,file,photo,name){
    
     if (sessionStorage.getItem('music') != null){
        audioBefID = sessionStorage.getItem('music');
        if(audioBefID != id){
        clearInterval(frT);
        clearInterval(fr);
        clearInterval(frD);
        if(document.getElementById("imgPlayCard"+audioBefID) != null){
        document.getElementById("imgPlayCard"+audioBefID).src = "icons/play.svg";
    }
        audioBef = document.getElementById(audioBefID);
        audioBef.src = '';
        audioBefDiv = document.getElementById("div"+audioBefID);
        audioBefDiv.remove();
        control = 1;
        } 
    }       
    if(control===1){
            if ( $( "#"+id+"" ).length != 0) { 
            /* elemento existe */ 
            }else{
            nameR = name.replace("***", "'");
            nameSearch = document.getElementById("name"+id);
            var $DinSelect = document.querySelector("#player"),
            HTMLTemp = $DinSelect.innerHTML,
            HTMLNew =   "<div id='div"+id+"' class='inside'>\n\
                        <img src='photos/albuns/"+photo+"' class='playerPhoto'>\n\
                        <h3 id='name'>"+nameR+"</h3>\n\
                        <div class='buttons'>\n\
                        <a onclick='playMusic(0)' class='playerButton' id='playB'><img src='icons/play-circle.svg'></a>\n\
                        <a onclick='pauseMusic(0)' class='playerButton' id='pauseB' style='display:none'><img src='icons/pause-circle.svg'></a>\n\
                        <a onclick='stopMusic(0)' class='playerButton'><img src='icons/stop-circle.svg'></a>\n\
                        <a onclick='back(30)' class='playerButton' id='back'><img src='icons/chevrons-left.svg'></a>\n\
                        <a onclick='skip(30)' class='playerButton' id='skip'><img src='icons/chevrons-right.svg'></a>\n\
                        </div>\n\
                        <audio id='"+id+"' src='musics/"+file+"'></audio>\n\
                        <div id='progress' onclick='barFunction()'>\n\
                        <div id='bar' ></div>\n\
                        </div>\n\
                        <h1 id='time'></h1></div>";
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
    }
}
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
    HTMLTemp = $DinSelect.innerHTML;
    sessionStorage.setItem('audioHTML', HTMLTemp);
    };
    
    
    })
    .catch(error => {
    });
  }
    timer(curTim);
    move(curTim);
    detect(curTim);
}
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
        fr = 100;
        frT = 100;
        }else{
        control = 1;
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
function barFunction(){
    alert("função em desenvolvimento");
}
function skip(sec){
    var id = sessionStorage.getItem('music');
    var audio = document.getElementById(id);
    var bynowtime = audio.currentTime;
    audio.currentTime = bynowtime+sec;
    move(id);
    timer(id);
    ableSkip = true;
}
function back(sec){
    var id = sessionStorage.getItem('music');
    var audio = document.getElementById(id);
    bynowtime = audio.currentTime;
    audio.currentTime = bynowtime-sec;
    move(id);
    timer(id);
    ableSkip = true;
}
function nextMusic(){
    
}
function createPL(){
    
}