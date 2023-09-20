<!-----------------VERIFIER PHP ICI----------------->
<?php
    require("connectDB.php");
    require("Crud.php");
    require("utils.php");

    init_php_session();
    grant_access(true);
    
    $db = connect();

    $equipes = Get_Equipes_And_Clubs($db);
    $entraineurs = Get_All_Trainers($db);

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="equipes.css"/>
    <link rel="stylesheet" href="templateStyle.css"/>
<!-----------------TITLE A COMPLETER----------------->
    <title>Gestion des Entraineurs</title>
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

<!-----------------TITLE A COMPLETER----------------->
        <h1>Attribution d'un entraineur à une équipe</h1>

<!-----------------SECTION 1----------------->       

            <div class="football_player_content_section">
            <!--<h2>Equipes et leurs entraineurs :</h2>-->

            <div id="AjoutClub">
                <form id="formClub" action="Update_Team_Trainer.php" method="POST">
                    <select name="Equipe" id="InputEquipe" required>
                        <option value="">Selectionnez une équipe</option>
                        <?php
                            if(count($equipes) > 0)
                            {
                                foreach($equipes as $equipe)
                                {
                                    echo '<option value="'.$equipe["IdEquipe"].'">Equipe : '.$equipe["NomEquipe"].' du club : '.$equipe["NomClub"].'</option>';
                                }
                            }
                        ?>
                    </select>
                    <select name="Trainer" id="InputTrainer">
                        <option value="">Selectionnez un Entraineur</option>
                        <?php
                            if(count($entraineurs) > 0)
                            {
                                foreach($entraineurs as $entraineur)
                                {
                                    echo '<option value="'.$entraineur["IdEntraineur"].'">'.$entraineur["nom"].' '.$entraineur["prenom"].'</option>';
                                }
                            }
                        
                        ?>
        
                    </select>
                    <select name="TrainerAdjoint" id="InputTrainerAdjoint">
                        <option value="">Selectionnez un Entraineur Adjoint</option>
                        <?php
                            if(count($entraineurs) > 0)
                            {
                                foreach($entraineurs as $entraineur)
                                {
                                    echo '<option value="'.$entraineur["IdEntraineur"].'">'.$entraineur["nom"].' '.$entraineur["prenom"].'</option>';
                                }
                            }
                        
                        ?>
                    </select>
                    <!--<input id="InputId" type="hidden" name="id" value="">-->
                    <input type="submit" id="submitbtn" value="Ajouter">
                </form>
            </div>

        </div>

    </div>
    <script src="formVerification.js"></script>
</body>

<footer>
    <?php
        include("footer.html")
    ?>
</footer>

</html>