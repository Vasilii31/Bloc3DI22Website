<?php
    require("connectDB.php");
    //require("Crud.php");
    require("utils.php");

    init_php_session();

    if(!is_logged())
    {
        //header("location: /auth.php");
    }
    $db = connect();


    
    $matchs = Get_Pending_Matchs($db);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styleIndex.css"/>
    <link rel="stylesheet" href="style_fixed.css"/>
    <title>Index</title>
</head>

<body>
<header>
    <div id="headerTop">
        <div class="header">
    <ul>
        <li><a href="#CreateFeuilleMatch">Créer</a></li>
        <li><a href="#FeuilleMatch">Mes Matchs</a></li>
        <li><a href="#Tools">Outils</a></li>
        <li><a href="#Contact">Se déconnecter</a></li>
    </ul>
    </div>
</div>
</header>

<!-- Carte des Matchs en cours -->
<section class="card">
      <h2>Matchs en cours</h2>
      <div class="match">
      <?php
        if(count($matchs) > 0)
        {
            var_dump($matchs);
            echo $matchs[0]["NomEquipe1"];
            echo $matchs[0]["NomEquipe2"];
        }
    ?>


<!-- A partir d'ici je ne suis pas sûr que cela soit bon, c'est un test

      </div>
      <div class="match">
        <h3>Match 2</h3>
        <p>Date : 26 juillet 2023</p>
        <p>Lieu : Stade ABC</p>
      </div>
-->
    </section>


<div id="boxMatchs">
    <div class="matchEnCours">
    <h1>Mes Matchs en cours :</h1>
    <?php
        if(count($matchs) > 0)
        {
            var_dump($matchs);
            echo $matchs[0]["NomEquipe1"];
            echo $matchs[0]["NomEquipe2"];
        }
    ?>
    </div>
</div>

</body>

<footer>
    <div id="footer">
    <?php
        include("footer.html")
    ?>
    </div>
</footer>

<link rel="stylesheet" href="style_fixed.css"/>



</html>