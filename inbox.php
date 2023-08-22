<?php
    require("connectDB.php");
    require("Crud.php");
    $db = connect();

    $applying = Get_pending_trainers($db);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="inboxStyle.css"/>
    <link rel="stylesheet" href="templateStyle.css"/>
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
            foreach($applying as $applyance)
            {
                echo '<div class="trainerLine">';
                echo '<p>'.$applyance["nom"].'</p>';
                echo '<p>'.$applyance["prenom"].'</p>';
                echo '<p>'.$applyance["mail"].'</p>';
                echo '<p>'.$applyance["numTel"].'</p>';
                echo '<button>Valider</button>';
                echo '<button>Refuser</button></div>';       
            }                
        ?>

    </div>
    <script src="acceuilPreConnexion.js"></script>
</body>

<footer>
    <?php
        include("footer.html")
    ?>
</footer>

</html>