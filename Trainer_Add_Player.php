<?php
    require "connectDB.php";
    require "Crud.php";

    $db = connect();
    if(isset($_GET["id"]))
    {
        //On recupere le nom et l'id de l'équipe transmise a la page en GET
        $equipe = Get_team($db, $_GET["id"]);
        if($equipe == null)
        {
            header("location: /DisplayAndRedirect.php?result=TEAMNOTFOUND");
            //on recupere les postes en BDD ou on le met en dur dans la page ?
            //$postes = Get_Postes($db);
            //if($postes == null)
                //header("location: /DisplayAndRedirect.php?result=KO");
        }

    }
    else
        header("location: /DisplayAndRedirect.php?result=KO");
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
    <title>Ajouter un joueur</title>
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
        <h1>Ajouter un joueur</h1>
<!-----------------SECTION 1----------------->       
        <div class="football_player_content_section">
            <h2>Equipe : <?php echo $equipe["NomEquipe"];?></h2>
        </div>       
<!-----------------SECTION 3----------------->
            <form id="add_player_form" method="POST" action="AddPlayer.php">
                <input class="add_player_inputs" id="InputNom" name="nom" type="text" placeholder="Nom" required>
                <input id="InputPrenom" name="prenom" type="text" placeholder="Prénom" required>
                <input id="InputNum" name="num" type="number" min="1" max="44" placeholder="Numéro de maillot" required>
                <input type="hidden" name="equipe" value=<?php echo "".$equipe["IdEquipe"]."";?>>
                <select name="poste" id="posteSelector">
                    <option value="">Poste de prédilection</option>
                    <option value="1">Ailier Gauche</option>
                    <option value="2">Ailier Droit</option>
                    <option value="3">Avant Centre</option>
                    <option value="4">Milieu Droit</option>
                    <option value="5">Milieu Centre</option>
                    <option value="6">Milieu Gauche</option>
                    <option value="7">Défenseur Droit</option>
                    <option value="8">Défenseur Gauche</option>
                    <option value="9">Défenseur Central</option>
                    <option value="10">Gardien</option>
                </select>
                <input type="submit" value="Valider">
            </form>           
    </div>   
    <script src="formVerification.js"></script>
    <script src="addPlayer.js"></script>
</body>

<footer>
    <?php
        include("footer.html")
    ?>
</footer>

</html>