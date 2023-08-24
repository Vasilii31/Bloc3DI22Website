<?php
    require("connectDB.php");
    //require("Crud.php");
    require("utils.php");

    /*init_php_session();

    if(!is_logged())
    {
        header("location: /auth.php");
    }*/
    $db = connect();
    //if($_SESSION["IdEntraineur"] != "")
    //{
        //$matchsAcompleter = Get_Matches_To_Complete($db, $_SESSION["IdEntraineur"]);
        $matchsAcompleter = Get_Matches_To_Complete($db, 1);
        //$prochainsMatchCompletes = Get_Matches_Completes($db, 1);
        //var_dump($matchsAcompleter);
        //$matchsAvenir = Get_Incoming_Matches($db, $_SESSION["IdEntraineur"]);
    //}
    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="indexStyle.css"/>
    <title>FootClick - Acceuil</title>
</head>
<header>
    <?php
        include("header.php");
    ?>
</header>
<body>

    
    <div class="indexPage_container">
        <div class="football_player_content_container">

        <!-----------------TITLE A COMPLETER----------------->
            <h1>Matchs à compléter</h1>

            <?php

                foreach($matchsAcompleter as $match)
                {
                    echo '<a href="feuilleMatchEntraineur.php?feuille='.$match["idfeuille"].'"><div class="Match"><p>'.$match["DateRencontre"].'</p>';
                    echo '<p>'.$match["Lieu"].'</p>';
                    echo '<p>'.$match["monEquipe"].'</p>';
                    echo '<p>'.$match["equipeAdverse"].'</p></div></a>';
                }

            ?>
        <!-----------------SECTION 1----------------->       
            <div class="football_player_content_section">
                <h2>Titre Section 1</h2>

        <!-----------------SOUS SECTION 1.1-----------------> 
                <div class="football_player_content_subsection">
                    <p>Paragraphe</p>
                </div>

            </div>

        </div>
        <div class="football_player_content_container">

        <!-----------------TITLE A COMPLETER----------------->
            <h1>Matchs à venir déjà complétés</h1>


        <!-----------------SECTION 1----------------->       
            <div class="football_player_content_section">
                <h2>Titre Section 1</h2>

        <!-----------------SOUS SECTION 1.1-----------------> 
                <div class="football_player_content_subsection">
                    <p>Paragraphe</p>
                </div>

            </div>

        </div>
    </div>
    
</body>

<footer>
    <?php
        include("footer.html");
    ?>
</footer>

</html>