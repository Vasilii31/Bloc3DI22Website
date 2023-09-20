<?php
    require("connectDB.php");
    require("Crud.php");
    $db = connect();

    if(isset($_GET["approved"]) && isset($_GET["id"]))
    {
        Accept_Or_Decline_User($db, $_GET["id"], $_GET["approved"]);
    }

    $applying = Get_pending_trainers($db);
    $denied = Get_denied_trainers($db);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="inboxStyle.css"/>
    <link rel="stylesheet" href="templateStyle.css"/>
<!-----------------INBOX ADMINISTRATEURS----------------->
    <title>Inbox</title>
</head>

<!-- MANQUE HEADER AVEC LOGO FFF -->

<body>
<!--Football Player Image-->
    <div class="football_player_image_container">
        <img src="img/Football_player.png" alt="Joueur de foot tirant dans un ballon" class="football_player_image">
    </div>
<!--INBOX-->
        <div class="football_player_content_container">
            <h1>Demandes de validation en attente</h1>
            <div class="football_player_content_subsection">
                <?php 
                    foreach($applying as $applyance)
                    {
                        // echo '<div class="trainerLine">';
                        echo '<p>'.$applyance["nom"].'</p>';
                        echo '<p>'.$applyance["prenom"].'</p>';
                        echo '<p>'.$applyance["mail"].'</p>';
                        echo '<p>'.$applyance["numTel"].'</p>';
                        echo '<div class="buttons"><a href="inbox.php?approved=true&id='.$applyance["IdUser"].'" ><button ">Valider</button></a>';
                        echo '<a href="inbox.php?approved=false&id='.$applyance["IdUser"].'" ><button ">Refuser</button></a></div>';
                    }                
                ?>
            </div>

        </div>
        <div class="football_player_content_container" id="deniedUsers">
            <h1>Demandes refusées</h1>
            <?php 
                foreach($denied as $denieditem)
                {
                    echo '<div class="trainerLine">';
                    echo '<p class="pnomprenom">'.$denieditem["nom"].'</p>';
                    echo '<p class="pnomprenom">'.$denieditem["prenom"].'</p>';
                    echo '<p class="mail">'.$denieditem["mail"].'</p>';
                    echo '<p>'.$denieditem["numTel"].'</p>';
                    echo '<a href="inbox.php?approved=true&id='.$denieditem["IdUser"].'" ><button ">Valider</button></a></div>';
                }                
            ?>
        </div>
        

</body>

<footer>
    <?php
        include("footer.html");
    ?>
</footer>

</html>