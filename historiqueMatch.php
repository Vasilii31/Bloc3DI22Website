<?php
    require("connectDB.php");
    require("Crud.php");
    $db = connect();
    $historiqueMatch = Get_All_Matches_infos($db);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="inboxStyle.css"/>
    <link rel="stylesheet" href="templateStyle.css"/>
    <link rel="stylesheet" href="navBar.css"/>
<!-----------------TITLE A COMPLETER----------------->
    <title>Historique des matchs</title>
</head>

<!-- MANQUE HEADER AVEC LOGO FFF -->
<body>

    <!-- Barre de navigation -->
    <nav>
      <ul>
        <li><a href="#">Accueil</a></li>
        <li><a href="#">Profil</a></li>
        <li><a href="#">Paramètres</a></li>
        <li><a href="#">Déconnexion</a></li>
      </ul>
    </nav>
  </header>

<!--Football Player Image-->
    <div class="football_player_image_container">
        <img src="img/Football_player.png" alt="Joueur de foot tirant dans un ballon" class="football_player_image">
    </div>
    
<!--Container for Football Player's page, here: "TITRE  H1"---------------------->

        <div class="football_player_content_container">
            <h2>Résultats des derniers matchs</h2>
                <div class="football_player_content_section">

                    <?php 
                    foreach($historiqueMatch as $feuilledematch)
                    {
                        echo '<a href="#"><div class="Match">';
                        echo '<p>Le : '.$feuilledematch["DateRencontre"].'</p>';
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


    <script src="acceuilPreConnexion.js"></script>
</body>

<footer>
    <?php
        include("footer.html")
    ?>
</footer>

</html>