<?php
    require("connectDB.php");
    require("Crud.php");
    require("utils.php");

    $db = connect();

    init_php_session();

    var_dump($_SESSION);
    //si l'utilisateur est connecté, qu'il n'est pas admin et qu'il a bien un IdEntraineur stocké dans la session
    if(is_logged() && $_SESSION['isAdmin'] == false && $_SESSION['IdEntraineur'] != '')
    {
        $myTeam = Get_IdTeam_FromTrainer($db, $_SESSION['IdEntraineur']);
        if($myTeam != '')
        {
            $myPlayers = Get_My_Players($db,$myTeam);
        } 
        else 
        {
            var_dump("une erreur BDD est survenue, nous la traitons dans les plus brefs délais");
            header("location: /DisplayAndRedirect.php?result=KO");
        }
        
    }
    else
    {
        echo "<p> Vous n'êtes pas autorisés à accéder à cette page</p>";
    }

    
    
////////A METTRE AILLEURS ????//////
// If DeleteIdJoueur exists, delete player
    if(isset($_GET['id']))
    {
        $id = intval($_GET['id']);
        
        $dbh = $db->prepare("DELETE FROM `joueurs` WHERE `IdJoueur` ='$id'");
        $dbh->execute();
    }
  


?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style2.css"/>
    <link rel="stylesheet" href="templateStyle.css"/>
<!-----------------TITLE A COMPLETER----------------->
    <title>Mon équipe</title>
</head>

<!-- MANQUE HEADER AVEC LOGO FFF -->

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
                        // echo "<table class='table5'><tr>";
                        // echo "<td class='cell1'>".$myPlayer['Nom']."</br>".$myPlayer['Prenom']."</td>";
                        // echo "<td class='cell2'> Numéro : ".$myPlayer['NumeroMaillot']."</td>";
                        // echo "<td class='cell3'> Poste :</br>".$myPlayer['NomPoste']."</td>";
                        // //Modify the player//
                        // echo "<td class='cell4'><button class='myTeamButton' >Modifier</button></td>";
                        // //Delete the player//
                        // echo "<td class='cell5'><button class='myTeamButton'><a href='myTeam.php?DeleteIdJoueur=".$myPlayer['IdJoueur']."'>Supprimer</a></button></td>";
                        // echo "</tr></table>";

                        echo "<p>".$myPlayer['Nom']." </p>";
                        echo "<p>".$myPlayer['Prenom']." - </p>";
                        echo "<p> Numéro : ".$myPlayer['NumeroMaillot']." - </p>";
                        echo "<p> Poste : ".$myPlayer['NomPoste']." </p>";
                        //Modify the player//
                        echo "<button class='myTeamButton'>Modifier</button> ";
                        //Delete the player//
                        echo "<button class='myTeamButton'><a href='myTeam.php?DeleteIdJoueur=".$myPlayer['IdJoueur']."'>Supprimer</a></button></br>";
                    }
                ?>
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