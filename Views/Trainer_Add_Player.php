<?php
    require("../Librairies/connectDB.php");
    require("../Librairies/Crud.php");
    require("../Librairies/utils.php");

    $db = connect();

    init_php_session();

    $equipe = Get_Team_FromTrainer($db, $_SESSION['IdEntraineur']);

    
    if (isset($_GET['UpdateIdJoueur']) && !empty($_GET['UpdateIdJoueur'])) {
        $updateIdJoueur = intval($_GET['UpdateIdJoueur']);

        if($updateIdJoueur > 0) {
            $joueur = Get_A_Player($db, $updateIdJoueur); 

            if($joueur != false) {
                $nom = $joueur['Nom'];
                $prenom = $joueur['Prenom'];
                $numeroMaillot = $joueur['NumeroMaillot'];
                $PostePredilection = $joueur['IdPostePredilection'];
            }
        } //////REDIRECTION DISPLAY AND REDIRECT
    }

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style2.css"/>
    <link rel="stylesheet" href="../css/templateStyle.css"/>
<!-----------------TITLE A COMPLETER----------------->
    <title>Ajouter un joueur</title>
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
        <?php
            if(isset($_GET['UpdateIdJoueur'])):?>

    <!-----------------MODIFIER UN JOUEUR----------------->
            <div class="football_player_content_section"> 
                <h1>Modifier un joueur</h1>
            
                <div class="football_player_content_subsection">
                    <h2>Equipe : <?php echo $equipe["NomEquipe"];?></h2>
                    
                    <form id="add_player_form" method="POST" action="../Back/AddPlayer.php?UpdateIdJoueur=<?php echo ''.$updateIdJoueur;?>">
                        <input class="add_player_inputs" id="InputNom" name="nom" type="text" value="<?php echo $joueur['Nom']?>" required>
                        <input id="InputPrenom" name="prenom" type="text" value="<?php echo $joueur['Prenom']?>" required>
                        <input id="InputNum" name="num" type="number" min="1" max="44" value="<?php echo $joueur['NumeroMaillot']?>" required>
                        <input type="hidden" name="equipe" value=<?php echo "".$equipe["IdEquipe"]."";?>>
                        <select name="poste" id="posteSelector">
                            <option value="<?php echo $joueur['IdPostePredilection']?>"><?php echo $joueur['NomPoste']?></option>
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
                        <input type="submit" class="submit_button" value="Modifier">
                    </form>
                </div>
            </div>

        <?php
            else:?>
    <!-----------------AJOUTER UN JOUEUR----------------->
            <div class="football_player_content_section"> 
                <h1>Ajouter un joueur</h1>
            
                <div class="football_player_content_section">
                    <h2>Equipe : <?php echo $equipe["NomEquipe"];?></h2>       

                    <form id="add_player_form" method="POST" action="../Back/AddPlayer.php">
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
                        <input type="submit" class="submit_button" value="Valider">
                    </form>
                </div>
            </div>
        <?php endif; ?>
    </div>

      

    <script src="../scriptsJS/formVerification.js"></script>
    <script src="../scriptsJS/addPlayer.js"></script>
</body>

<footer>
    <?php
        include("footer.html")
    ?>
</footer>

</html>