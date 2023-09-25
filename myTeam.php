<?php
    require("connectDB.php");
    require("Crud.php");
    require("utils.php");

    $db = connect();

    init_php_session();
    grant_access(false);

    if(isset($_GET['DeleteIdJoueur']) && !empty($_GET['DeleteIdJoueur']))
    {
        Delete_Player($db, intval($_GET['DeleteIdJoueur']));
        echo "<p>Joueur supprimé avec succès.</p>";
    }
    

    //If user is logged + not admin + Id Trainer exist -> get id team for this trainer and get players from the team
    if(is_logged() && $_SESSION['isAdmin'] == false && $_SESSION['IdEntraineur']!= '')
   
    {
        
        $myTeam = Get_IdTeam_FromTrainer($db, $_SESSION['IdEntraineur']);

        if(intval($myTeam) > 0)
        {
            $myPlayers = Get_My_Players($db,$myTeam);
        } 
        else 
        {
            var_dump("une erreur BDD est survenue, nous la traitons dans les plus brefs délais");
            // header("location: ./DisplayAndRedirect.php?result=KO");
        }
  
    }
    else
    {
        echo "<p>Vous n'êtes pas autorisé à accéder à cette page</p>";
    }
    


?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/style2.css"/>
    <link rel="stylesheet" href="./css/templateStyle.css"/>
<!-----------------TITLE A COMPLETER----------------->
    <title>Mon équipe</title>
</head>

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

<!--Container for Football Player's page, here: "TITRE  H1"---------------------->
    <div class="football_player_content_container">

<!-----------------My team----------------->
        <h1>Mon équipe</h1>


<!-----------------Team Composition-----------------> 
        <div class="football_player_content_section">
            <div class="football_player_content_subsection" id="my_team">
                <!--Show all the players in the team-->
                <?php 
                    foreach($myPlayers as $myPlayer)
                    {
                        echo "<p>".$myPlayer['Nom']." </p>";
                        echo "<p>".$myPlayer['Prenom']." - </p>";
                        echo "<p> Numéro : ".$myPlayer['NumeroMaillot']." - </p>";
                        echo "<p> Poste : ".$myPlayer['NomPoste']." </p>";
                        //Modify the player//
                        echo "<button class='myTeamButton'><a href='./Trainer_Add_Player.php?UpdateIdJoueur=".$myPlayer['IdJoueur']."'>Modifier</a></button> ";
                        //Delete the player//
                        echo "<button class='myTeamButton'><a href='myTeam.php?DeleteIdJoueur=".$myPlayer['IdJoueur']."'>Supprimer</a></button> </br></br>";
                    }
                ?>
                <button class='myTeamButton'><a href="Trainer_Add_Player.php">Ajouter un Joueur</a></button>
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