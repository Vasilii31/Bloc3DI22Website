<!-----------------VERIFIER PHP ICI----------------->
<?php
    require("connectDB.php");
    require("Crud.php");

    $db = connect();
    /*init_php_session();

    if(!islogged() || !isAdmin())
    {
        header("location: auth.php");
    }*/

    $arbitres = Get_Referees($db);

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="arbitre.css"/>
    <link rel="stylesheet" href="templateStyle.css"/>
<!-----------------TITLE A COMPLETER----------------->
    <title>Gestion des Arbitres</title>
</head>

<!-- MANQUE HEADER AVEC LOGO FFF -->

<body>

<!--Football Player Image-->
    <div class="football_player_image_container">
        <img src="img/Football_player.png" alt="Joueur de foot tirant dans un ballon" class="football_player_image">
    </div>

<!--Container for Football Player's page, here: "TITRE  H1"---------------------->
    <div class="football_player_content_container">

<!-----------------TITLE A COMPLETER----------------->
        <h1>Arbitres existants</h1>
    <!-----------------SECTION 1----------------->       
        <div class="football_player_content_section">
            <?php 
                if(count($arbitres) > 0)
                {
                    foreach($arbitres as $arbitre)
                    {
                        echo "<p id='nomArbitre".$arbitre['IdArbitre']."'>".$arbitre['NomArbitre']." </p>";
                        echo "<p id='nationaliteArbitre".$arbitre['IdArbitre']."'>".$arbitre['Nationalite']." </p>";
                        //Modify the referee//
                        echo '<button onclick="To_Modify_Arbitre_Form('.$arbitre['IdArbitre'].')">Modifier</button> ';
                        //Delete the referee//
                        echo "<button class=''><a href=''>Supprimer</a></button></br>";
                    }
                }
                
            ?>
        </div>
<!-----------------SECTION 2-----------------> 
            <div class="football_player_content_section">
                <button id="" onclick="show_Arbitre_Form()">Ajouter un Arbitre</button>
                <div id="AjoutArbitre">
                    <form id="formArbitre" action="AddAbitre.php" method="POST">
                        <input id="InputNom" type="text" name="Nom" placeholder="Nom" required>
                        <input id="InputNationalite" type="text" name="Nationalite" placeholder="Nationalité" required>
                        <input id="InputId" type="hidden" name="id" value="">
                        <input type="submit" id="submitbtn" value="Valider">
                    </form>
                </div>

            </div>
        
        


    </div>
    <script src="formVerification.js"></script>
    <script src="addArbitre.js"></script>
</body>

<footer>
    <?php
        include("footer.html")
    ?>
</footer>

</html>