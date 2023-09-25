<!-----------------VERIFIER PHP ICI----------------->
<?php
    require("connectDB.php");
    require("Crud.php");
    require("utils.php");

    init_php_session();
    grant_access(true);
    
    $db = connect();

    //recuperer les clubs existants
    $clubs = Get_Clubs($db);
    $equipes = Get_Equipes_And_Clubs($db);

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/equipes.css"/>
    <link rel="stylesheet" href="./css/templateStyle.css"/>

    <title>Gestion des Equipes</title>
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

    <div class="football_player_content_container">

        <h1>Equipes existantes</h1>


            <div class="football_player_content_section">
                <?php 
                    if(count($equipes) > 0)
                    {
                        //var_dump($equipes);
                        foreach($equipes as $equipe)
                        {
                            echo "<p> Club : ".$equipe['NomClub']."   ";
                            echo " Equipe : ".$equipe['NomEquipe']." </p>";
                        }
                    }
                    
                ?>

            </div>

            <div class="football_player_content_section">
            <!--<button id="" onclick="show_Equipe_Form()">Créer une Equipe</button>-->
            <div id="AjoutClub">
                <form id="formClub" action="AddEquipe.php" method="POST">
                    <select name="Club" id="InputClub">
                        <option value="">Club de l'équipe</option>
                        <?php
                            if(count($clubs) > 0)
                            {
                                foreach($clubs as $club)
                                {
                                    echo '<option value="'.$club["IdClub"].'">'.$club["NomClub"].'</option>';
                                }
                            }
                        
                        ?>
        
                    </select>
                    <input id="InputNom" type="text" name="Nom" placeholder="Nom" required>
                    <!--<input id="InputId" type="hidden" name="id" value="">-->
                    <input type="submit" id="submitbtn" class="submit_button" value="Ajouter">
                </form>
            </div>
            <p id="clubSelectWarning"><br>Veuillez selectionner un club à laquelle appartient l'équipe que vous souhaitez créer.<br>
                            Si le club n'existe pas, vous pouvez le créer dans le menu "Créer" => "Créer un club".
            </p>

        </div>

    </div>
    <script src="formVerification.js"></script>
    <script src="addEquipe.js"></script>
</body>

<footer>
    <?php
        include("footer.html")
    ?>
</footer>

</html>