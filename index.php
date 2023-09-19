<?php
    require("connectDB.php");
    //require("Crud.php");
    require("utils.php");

    init_php_session();

    if(!is_logged())
    {
        header("location: /auth.php");
    }

    $db = connect();
    $admin = is_admin();
    if($_SESSION["IdEntraineur"] != "")
    {
        //$matchsAcompleter = Get_Matches_To_Complete($db, $_SESSION["IdEntraineur"]);
        $matchsAcompleter = Get_Matches_To_Complete($db, $_SESSION["IdEntraineur"]);
        //$prochainsMatchCompletes = Get_Matches_Completes($db, 1);
        //var_dump($matchsAcompleter);
        //$matchsAvenir = Get_Incoming_Matches($db, $_SESSION["IdEntraineur"]);
    }
    elseif(is_admin())
    {

    }
    
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
            <?php if(!is_admin()):   ?>
            <h1>Prochains matchs de mon équipe à compléter</h1>

            <?php
                if(count($matchsAcompleter) == 0)
                {
                    echo "<h2>Aucun match à compléter pour l'instant.</h2>";
                }
                else
                {
                    foreach($matchsAcompleter as $match)
                    {
                        echo '<a href="feuilleMatchEntraineur.php?idFeuille='.$match["idfeuille"].'"><div class="Match"><p>'.$match["DateRencontre"].'</p>';
                        echo '<p>'.$match["Stade"].'</p>';
                        echo '<p>'.$match["monEquipe"].'</p>';
                        echo '<p>'.$match["equipeAdverse"].'</p></div></a>';
                    }
                }
                
            ?>
            <?php else:?>
                <h1>Matchs en attente de complétion par les entraineurs</h1>

                <?php

                    /*foreach($matchsAcompleter as $match)
                    {
                        echo '<a href="feuilleMatchEntraineur.php?idFeuille='.$match["idfeuille"].'"><div class="Match"><p>'.$match["DateRencontre"].'</p>';
                        echo '<p>'.$match["Stade"].'</p>';
                        echo '<p>'.$match["monEquipe"].'</p>';
                        echo '<p>'.$match["equipeAdverse"].'</p></div></a>';
                    }*/

                ?>
            <?php endif;?>

        </div>



       
    </div>
    
</body>

<footer>
    <?php
        include("footer.html");
    ?>
</footer>

</html>