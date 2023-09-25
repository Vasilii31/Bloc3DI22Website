<?php
    require("connectDB.php");
    require("Crud.php");
    require("utils.php");

    init_php_session();
    grant_access(false);
    $db = connect();
    $historiqueMatch = Get_All_Matches_infos($db);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/inboxStyle.css"/>
    <link rel="stylesheet" href="./css/templateStyle.css"/>
    <link rel="stylesheet" href="./css/detailsMatchs.css"/>
    <link rel="stylesheet" href="./css/navBar.css"/>
<!-----------------TITLE A COMPLETER----------------->
    <title>Détails du matchs</title>
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
    
<!--Container for Football detais page, here: "TITRE  H1"---------------------->

        <div class="football_details_content_container">
            <h2>Détails du match</h2>

                    <div class="boxResultatsMatch">
                        Ici sera la date du match
                        <div class="nomEquipes">
                            OM - Pau
                        </div>
                            <div class="scoreEquipes"> 
                                3 - 1
                            </div>
                    </div>

                    <div class="boxEvenementsMatch">Evènements
                        <div class="boxButs">
                            <div class="butsEquipeGauche">
                                10' minutes - But - Papin
                            </div>
                            <div class="butsEquipeDroite">
                                25' minutes - But - Zidane
                            </div>
                        </div>
                        <div class="boxCartons">Cartons
                            <div class="cartonsEquipeGauche">
                                30' minutes - Carton jaune - Henry
                            </div>
                            <div class="cartonsEquipeDroite">
                                35' minutes - Carton rouge - Anelka
                            </div>
                        </div>

                        <div class="boxFautes">Fautes
                            <div class="fautesEquipeGauche">
                                29' minutes - Faute - Henry
                            </div>
                            <div class="fautesEquipeDroite">
                                67' minutes - Faute - Pires
                            </div>
                        </div>

                        <div class="boxRemplacements">Remplacements
                            <div class="remplacementsEquipeGauche">
                                60' minutes - Remplacement - Petit par Trezeguet
                            </div>
                            <div class="remplacementsEquipeDroite">
                                60' minutes - Remplacement - Barthez par Lloris
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