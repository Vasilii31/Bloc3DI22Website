<!-----------------VERIFIER PHP ICI----------------->
<?php
    require("../Librairies/connectDB.php");
    require("../Librairies/Crud.php");
    require("../Librairies/utils.php");

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
    <link rel="stylesheet" href="../css/equipes.css"/>
    <link rel="stylesheet" href="../css/templateStyle.css"/>
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
        <img src="../img/Football_player.png" alt="Joueur de foot tirant dans un ballon" class="football_player_image">
    </div>


    <div class="football_player_content_container">

        <h1>Attribution d'un entraineur à une équipe</h1>

        <div class="football_player_content_section">
            <!--<h2>Equipes et leurs entraineurs :</h2>-->

                
            <form id="formClub" action="../Back/Update_Team_Trainer.php" method="POST">
                <select name="Equipe" id="InputEquipe" required>
                    <option value="">Sélectionnez une équipe</option>
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
                    <option value="">Sélectionnez un entraineur</option>
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
                    <option value="">Sélectionnez un entraineur adjoint</option>
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
                <input type="submit" class="submit_button" value="Ajouter">
            </form>
               
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