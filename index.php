<html>
    <head>
        <meta charset="UTF-8">
        <title>SpotClone</title>
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7/jquery.js"></script> 
        <script src="http://malsup.github.com/jquery.form.js"></script> 
        <script src="js/main.js"></script>
    <script> 
        window.onload = initPage;
function initPage(){
    $('#content').load('./listMusic.php?search=').hide().fadeIn('slow');
    //mantém o player ao atualizar a página
    if(sessionStorage.getItem('audioHTML') != null){
        var $DinSelect = document.querySelector("#player");
        audioHTML = sessionStorage.getItem('audioHTML');
        $DinSelect.innerHTML = audioHTML;
    }
    //mantém o titulo ao atualizar a página
    if(sessionStorage.getItem('title') != null){
        document.title = sessionStorage.getItem('title');
    }
    //mantém o tempo corrente da música ao atualizar a página
    if(sessionStorage.getItem('current') != null){
        currentTime = sessionStorage.getItem('current');
        if(sessionStorage.getItem('music') != null){
        currentAudioId = sessionStorage.getItem('music');
        currentAudio = document.getElementById(currentAudioId);
        currentAudio.currentTime = currentTime;
        control = 0;
        tocar(currentAudioId);
        
    }
    }
    
}  
        $(document).ready(function() { 
            $('#search').ajaxForm(function() {
                
                var search = $('#name').val();
                
                searchClean = search.replace(/\s/g, '+');
                $('#content').load('./listMusic.php?search='+searchClean+'').hide().fadeIn('slow');
            }); 
        });  
    </script>
        <style>
            html, body {
            height: 100%;
            margin: 0px;
            }
            #all{
                height: 100%;
                width: 100%;
                display: flex;
                flex-direction: column;
                font-family: sans-serif;
            }
            #up{
                width: 100%;
                height: 80%;
                display: flex;
                
            }
            #menu{
                width: 30%;
                height: 100%; 
                background-color: #333333;
                border-right: 1px solid white;
            }
            #content{
                width: 70%;
                height: 100%;
                background-color: #333333;
                overflow: auto;
                display: flex;
                justify-content: center;
                flex-wrap: wrap;
            }
            #player{
                display: flex;
                align-items: center;
                height: 20%;
                width: 100%;
                background-color: gray;
                min-height: 125px;
            }
            .music{
              width: 200px;
              height: 200px;
              border-radius: 12px;
              cursor: pointer;
              position: relative;
              margin: 12px;
            }
            .empty{
              width: 200px;
              height: 200px;
              position: relative;
              margin: 12px;
            }
            .playButton{
                display: flex;
                justify-content: center;
                align-items: center;
                background-color: #0000B3;
                height: 50px;
                width: 50px;
                border-radius: 50%;
                position:absolute;
                z-index: 2;
                right: 10px;
                bottom: 10px;
                opacity: 0;
            }
            .nameMusic{
                width: 100%;
                border-radius: 12px 12px 0 0;
                background-color: rgba(0,0,0,0.7);
                color: white;
                margin: 0;
                position: absolute;
                top:0;
            }
            .nameArtist{
                width: 100%;
                border-radius: 0 0 12px 12px ;
                background-color: rgba(0,0,0,0.7);
                color: white;
                margin: 0;
                position: absolute;
                bottom: 0;
            }
            .music:hover .playButton{
                opacity: 1;
            }
            
            .playerButton{
                cursor: pointer;
                zoom: 2;
                height: fit-content;
                width: fit-content;
            }
            .playerPhoto{
                align-self: flex-start;
                height: 100px;
                width: 100px;
            }
            .inside{
                width: 100%;
                display: flex;
                justify-content: space-between;
                align-items: center;
            }
            #progress {
                height: 5px;
                background-color: #666666;
                width: 50%;
            }

            #bar {
                width: 0%;
                height: 5px;
                background-color: #333333;
            }
            .buttons{
                display: flex;
                flex-direction: row;
            }
            #name{
                width: 200px;
                white-space: nowrap;
                overflow: hidden;
                text-overflow: ellipsis;
            }
            #time{
                width: 100px;
            }
            #search{
                background-color: #666666;
                height: 50px;
                line-height: 50px;
                display: flex;
                justify-content: space-between;
                padding: 5px;
            }
            #search #name{
                width: 100%;
                font-size: 20px;
                background-color: transparent;
                border: 0;
                border-bottom: 2px solid gray;
                outline: none;
            }
        </style>
    </head>
    <body>
        
        <div id="all">
            <div id="up">
        <div id="menu">
            <form id="search" action="index.php" method="post"> 
            <input type="text" id="name" /> 
            <input type="image" src="icons/search.svg" /> 
        </form>
        </div>
        <div id="content">
            
        </div>
            </div>
        <div id="player">
            
        </div>
        </div>
    </body>
</html>
