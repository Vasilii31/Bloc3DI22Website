<?php
    require("../Librairies/connectDB.php");
    require("../Librairies/Crud.php");
    require("../Librairies/utils.php");

    init_php_session();
    if(!is_logged())
    {
        header("location: ../Views/auth.php");
        return;
    }
    $db = connect();
    $historiqueMatch = Get_All_Matches_infos($db);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/inboxStyle.css"/>
    <link rel="stylesheet" href="../css/templateStyle.css"/>
    <link rel="stylesheet" href="../css/detailsMatchs.css"/>
<!-----------------TITLE A COMPLETER----------------->
    <title>Historique des matchs</title>
</head>
<header>
    <?php
        include("header.php");
    ?>
</header>
<body>

<!--Football Player Image-->
    <div class="football_player_image_container">
        <img src="../img/Football_player.png" alt="Joueur de foot tirant dans un ballon" class="football_player_image">
    </div>
    
<!--Container for Football Player's page, here: "TITRE  H1"---------------------->

        <div class="football_player_content_container">
            <h2>Résultats des derniers matchs</h2>
                <div class="football_player_content_section">

                    <?php 
                    foreach($historiqueMatch as $feuilledematch)
                    {
                        echo '<a href="../Views/detailsMatch.php?id='.$feuilledematch["IdFeuille"].'"><div class="Match">';
                        echo '<p>Le : '.date("d-m-Y", strtotime($feuilledematch["DateRencontre"])).'</p>';
                        echo '<p>'.$feuilledematch["Equipe1"].' contre '.$feuilledematch["Equipe2"].'</p>';

                        if($feuilledematch["MatchNul" == false])
                        {
                            echo '<div class="score"><p class="win">'.$feuilledematch["ScoreEquipeGagnante"].'</p><p>-</p>';
                            echo '<p class="loss">'.$feuilledematch["ScoreEquipePerdante"].'</p></div>';
                        }
                        else
                        {
                            echo '<div class="score"><p>'.$feuilledematch["ScoreEquipeGagnante"].'</p><p>-</p>';
                            echo '<p>'.$feuilledematch["ScoreEquipePerdante"].'</p></div>';
                        }
                        echo '</div></a>';
                    }
                    ?>
                    </div>
            
                </div>

        </div>

</div>


    <script src="../jsScripts/acceuilPreConnexion.js"></script>
</body>

<footer>
    <?php
        include("footer.html")
    ?>
</footer>

</html>