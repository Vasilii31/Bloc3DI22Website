<!-----------------VERIFIER PHP ICI----------------->
<?php
    require("../Librairies/connectDB.php");
    require("../Librairies/Crud.php");
    require("../Librairies/utils.php");

    init_php_session();
    grant_access(true);
    
    $db = connect();


    //recuperer les clubs existants
    $clubs = Get_Clubs($db);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/clubs.css"/>
    <link rel="stylesheet" href="../css/templateStyle.css"/>

    <title>Gestion des Clubs</title>
</head>
<header>
    <?php
        include("header.php");
    ?>
</header>

<body>

<!--Football Player Image-->
    <div class="football_player_image_container">
        <img src="../img/Football_player.png" alt="Joueur de foot tirant dans un ballon" class="football_player_image">
    </div>

<!--Container for Football Player's page, here: "TITRE  H1"---------------------->
    <div class="football_player_content_container">

<!-----------------TITLE A COMPLETER----------------->
        <h1>Clubs existants</h1>


<!-----------------SECTION 1----------------->       
            <div class="football_player_content_section">
                <?php 
                    if(count($clubs) > 0)
                    {
                        foreach($clubs as $club)
                        {
                            echo "<div class='club'><p id='nomClub".$club['IdClub']."'>".$club['NomClub']." </p></br>";
                            
                        }
                    }
                    
                ?>

            </div>

            <div class="football_player_content_section">
            <button id='add-button' onclick="show_Club_Form()">Créer un Club</button>
            <div id="AjoutClub">
                <form id="formClub" action="../Back/AddClub.php" method="POST">
                    <input id="InputNom" type="text" name="Nom" placeholder="Nom" required>
                    <input id="InputId" type="hidden" name="id" value="">
                    <input type="submit" id="submitbtn" class="submit_button" value="Valider">
                </form>
            </div>

        </div>

    </div>
    <script src="../jsScripts/formVerification.js"></script>
    <script src="../jsScripts/addClub.js"></script>
</body>

<footer>
    <?php
        include("footer.html")
    ?>
</footer>

</html>