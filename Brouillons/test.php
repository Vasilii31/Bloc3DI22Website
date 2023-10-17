<?php
    require("connectDB.php");
    require("Crud.php");
    $db = connect();
    $idEquipe = 1;

    $listeJoueur = Get_All_Players_from_team($db, $idEquipe);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/inboxStyle.css"/>
    <link rel="stylesheet" href="./css/templateStyle.css"/>
<!-----------------TITLE A COMPLETER----------------->
    <title>Inbox</title>
</head>

<!-- MANQUE HEADER AVEC LOGO FFF -->
<body>
<!--Football Player Image-->
    <div class="football_player_image_container">
        <img src="img/Football_player.png" alt="Joueur de foot tirant dans un ballon" class="football_player_image">
    </div>
    
<!--Container for Football Player's page, here: "TITRE  H1"---------------------->
    <div class="football_player_content_container">
        
        <?php 

            foreach($listeJoueur as $joueur)
            {
                echo '<p>'.$joueur["Nom"].'</p>';
                echo '<p>'.$joueur["Prenom"].'</p>';
            }
        
        ?>
        
        <!--<div class="Player_Container">
            
            <p>Nom</p>
            <p>Prenom</p>
            <p>Numero Maillot</p>
            <p>Poste</p>
            <button>Modifier</button>
            <button>Supprimer</button>
        </div>-->
    </div>
    <script src="acceuilPreConnexion.js"></script>
</body>

<footer>
    <?php
        include("footer.html")
    ?>
</footer>

</html>