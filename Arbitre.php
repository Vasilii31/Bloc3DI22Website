<?php
    require("connectDB.php");
    require("Crud.php");
    require("utils.php");

    init_php_session();
    grant_access(true);

    $db = connect();

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
<!-----------------GESTION DES ARBITRES----------------->
    <title>Gestion des Arbitres</title>
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

<!--ARBITRES EXISTANTS + AJOUTER UN ARBITRE-->
    <div class="football_player_content_container">

        <h1>Arbitres existants</h1>
    <!-----------------ARBITRES EXISTANTS----------------->       
        <div class="football_player_content_section">
        <div class="football_player_content_subsection" id='arbitres'>
                <?php 
                    if(count($arbitres) > 0)
                    {
                        foreach($arbitres as $arbitre)
                        {
                            echo "<p id='nomArbitre".$arbitre['IdArbitre']."'>".$arbitre['NomArbitre']." </p>";
                            echo "<p class='i' id='nationaliteArbitre".$arbitre['IdArbitre']."'>".$arbitre['Nationalite']." </p>";
                            //Modify the referee//
                            echo '<p><button onclick="To_Modify_Arbitre_Form('.$arbitre['IdArbitre'].')">Modifier</button> </p> ';
                            //Delete the referee//
                            echo "<p><button class=''><a href=''>Supprimer</a></button> </p></br></br>";
                        }
                    }
                    
                ?>
            </div>
        </div>
<!-----------------AJOUTER UN ARBITRE-----------------> 
            <div class="football_player_content_section ajouter-arbitre">
                <button id='add-button' onclick="show_Arbitre_Form()">Ajouter un arbitre</button>
                </br>
                <div id="AjoutArbitre">
                    <form id="formArbitre" action="AddAbitre.php" method="POST">
                        <input id="InputNom" type="text" name="Nom" placeholder="Nom" required>
                        <input id="InputNationalite" type="text" name="Nationalite" placeholder="Nationalité" required>
                        <input id="InputId" type="hidden" name="id" value="">
                        </br>
                        </br>
                        <input type="submit" id="submitbtn" class="submit_button" value="Valider">
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