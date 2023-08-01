<?php
    require "connectDB.php";
    require "Crud.php";

    $db = connect();
    if(isset($_GET["id"]))
    {
        $equipe = Get_team($db, $_GET["id"]);
        if($equipe == null)
            header("location: /DisplayAndRedirect.php?result=TEAMNOTFOUND");

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
            <form id="add_player_form" method="POST" action="">
                <input class="add_player_inputs" id="InputNom" name="nom" type="text" placeholder="Nom" required>
                <input id="InputPrenom" name="prenom" type="text" placeholder="Prénom" required>
                <input id="InputNum" name="num" type="number" min="1" max="44" placeholder="Numéro de maillot" required>
                <input type="hidden" name="equipe" value=<?php echo "".$equipe["IdEquipe"]."";?>>
                <select name="poste" id="">
                    <option value="">Poste de prédilection</option>
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