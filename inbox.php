<?php
    require("connectDB.php");
    require("Crud.php");
    require("utils.php");

    init_php_session();
    grant_access(true);

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
    <link rel="stylesheet" href="./css/inboxStyle.css"/>
    <link rel="stylesheet" href="./css/templateStyle.css"/>
<!-----------------INBOX ADMINISTRATEURS----------------->
    <title>Inbox</title>
</head>

<!-- MANQUE HEADER AVEC LOGO FFF -->
<header>
    <?php
        include("header.php");
    ?>
</header>
<body>
<!--Football Player Image-->
    <div class="football_player_image_container">
        <img src="img/Football_player.png" alt="Joueur de foot tirant dans un ballon" class="football_player_image">
    </div>
<!--INBOX-->
        <div class="football_player_content_container" id="waitingOrDenied">

            <div class="football_player_content_subsection" id="awaitingApprovals">
                <h2>Demandes de validation en attente</h2>
                <?php 
                    foreach($applying as $applyance)
                    {
                        echo '<p>'.$applyance["nom"].' - </p>';
                        echo '<p>'.$applyance["prenom"].' - </p>';
                        echo '<p>'.$applyance["mail"].' - </p>';
                        echo '<p>'.$applyance["numTel"].' </p>';
                        echo '<button><a href="inbox.php?approved=true&id='.$applyance["IdUser"].'">Valider</a></button>';
                        echo '<button><a href="inbox.php?approved=false&id='.$applyance["IdUser"].'">Refuser</a></button></br>';
                    }                
                ?>
            </div>

            <div class="football_player_content_subsection" id="deniedUsers">
                <h2>Demandes refusées</h2>
                    <?php 
                        foreach($denied as $denieditem)
                        {
                            echo '<p class="pnomprenom">'.$denieditem["nom"].' - </p>';
                            echo '<p class="pnomprenom">'.$denieditem["prenom"].' - </p>';
                            echo '<p class="mail">'.$denieditem["mail"].' - </p>';
                            echo '<p>'.$denieditem["numTel"].' </p>';
                            echo '<button><a href="inbox.php?approved=true&id='.$denieditem["IdUser"].'">Valider</a></button></br>';
                        }                
                    ?>
            </div>
            
        </div>
        

</body>

<footer>
    <?php
        include("footer.html");
    ?>
</footer>

</html>