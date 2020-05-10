<html>
    <head>
        <meta charset="UTF-8">
        <title>SpotClone</title>
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7/jquery.js"></script> 
        <script src="http://malsup.github.com/jquery.form.js"></script> 
        <script src="js/main.js"></script>
        <link href="https://fonts.googleapis.com/css2?family=Noto+Sans&display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="styles/index.css">
    </head>
    <body>
        
        <div id="all">
            <div id="up">
        <div id="menu">
            <form id="search" action="index.php" method="post"> 
                <section id="topS">
                <input type="text" id="name" /> 
                <input type="image" src="icons/search.svg" style="outline: none"/> 
                </section>
                <section>
                Música<input type="radio" id="musicSearch" name="typeSearch" value="music" checked="true">
                Álbum<input type="radio" id="albumSearch" name="typeSearch" value="album">
                </section>
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
