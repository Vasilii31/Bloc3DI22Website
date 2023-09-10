<?php
    require("connectDB.php");
    require("Crud.php");
    require("utils.php");

    $db = connect();

    init_php_session();

    $equipe = Get_Team_FromTrainer($db, $_SESSION['IdEntraineur']);

    // On déclare des variables pour stocker les info sur les joueurs
    $player = array(
        'Nom' => '',
        'Prenom' => '',
        'NumeroMaillot' => '',
        'IdEquipe' => '', 
        'IdPostePredilection' => ''
    );

    if(isset($_GET['UpdateIdJoueur']))
    {
        //on vérifie que ce qu'on a reçu en get est bien un int
        $IdJoueur = intval($_GET['UpdateIdJoueur']);

        if($IdJoueur != 0)
        {
            //on va faire une requête à la base de données pour verifier que le joueur existe, si c'est le cas, on stocket dans $players
            $players = Get_A_Player($db, $IdJoueur);
            
            if (count($players) > 0){
                foreach($players as $player)
                {
                   // ????
                }
            }  
        }
        else
        {
            //Si IdJoueur n'est pas valide ?
        }
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
            <h2>Equipe : <?php echo $equipe[0]["NomEquipe"];?></h2>
        </div>       
<!-----------------SECTION 3----------------->
        <form id="add_player_form" method="POST" action="AddPlayer.php">
                <input class="add_player_inputs" id="InputNom" name="nom" type="text" placeholder="Nom" value="<?php echo $player['Nom']; ?>" required>
                <input id="InputPrenom" name="prenom" type="text" placeholder="Prénom" value="<?php echo $player['Prenom']; ?>" required>
                <input id="InputNum" name="num" type="number" min="1" max="44" placeholder="Numéro de maillot" value="<?php echo $player['NumeroMaillot']; ?>" required>
                <input type="hidden" name="equipe" value=<?php echo "".$equipe[0]["IdEquipe"]."";?>>
                <input type="hidden" name="IdJoueur" value="<?php echo $IdJoueur; ?>">
                
                <select name="poste" id="posteSelector">
                    <option value="">Poste de prédilection</option>
                    <option value="1" <?php if ($player['IdPostePredilection'] == 1) echo 'selected'; ?>>Ailier Gauche</option>
                    <option value="2" <?php if ($player['IdPostePredilection'] == 2) echo 'selected'; ?>>Ailier Droit</option>
                    <option value="3" <?php if ($player['IdPostePredilection'] == 3) echo 'selected'; ?>>Avant Centre</option>
                    <option value="4" <?php if ($player['IdPostePredilection'] == 4) echo 'selected'; ?>>Milieu Droit</option>
                    <option value="5" <?php if ($player['IdPostePredilection'] == 5) echo 'selected'; ?>>Milieu Centre</option>
                    <option value="6" <?php if ($player['IdPostePredilection'] == 6) echo 'selected'; ?>>Milieu Gauche</option>
                    <option value="7" <?php if ($player['IdPostePredilection'] == 7) echo 'selected'; ?>>Défenseur Droit</option>
                    <option value="8" <?php if ($player['IdPostePredilection'] == 8) echo 'selected'; ?>>Défenseur Gauche</option>
                    <option value="9" <?php if ($player['IdPostePredilection'] == 9) echo 'selected'; ?>>Défenseur Central</option>
                    <option value="10" <?php if ($player['IdPostePredilection'] == 10) echo 'selected'; ?>>Gardien</option>
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