<?php
    require("connectDB.php");
    require("Crud.php");
    require("utils.php");

    init_php_session();
    grant_access(true);

    $db = connect();
    
    $clubs = Get_Clubs($db);
    $arbitres = Get_Referees($db);

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv=
    "X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style2.css"/>
    <link rel="stylesheet" href="templateStyle.css"/>
    <title>Création de Feuille de Match</title>
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

<!--Container for Football Player's page, here: "Création d'une Feuille de Match"-->
    <div class="football_player_content_container">
        
        <h1>Création d'une feuille de match</h1>
        
        <!-- <?php
        if($db == NULL)
        {
            echo "la connexion a la base de données a échoué";
        }
        else{
            echo "bravo connexion effectuée";
        }  ?> -->

        <form action="CreateFeuilleMatch.php" method="POST">

<!--Event-->       
            <div class="football_player_content_section">
                <h2>Rencontre</h2>

                <div class="football_player_content_subsection">
                    <label for="inputDate">Date :</label>
                    <input type="date" name="DateRencontre" onchange="dateHandler(value);" id="inputDate" min="<?php echo date('Y-m-d'); ?>" required>
                </div>

            </div>

<!--Teams and stadium-->
            <div class="football_player_content_section">

                <!--Teams-->
                <h2>Equipes</h2>
                <div class="football_player_content_subsection" id="teams">

                    <div id="equipe1">
                        <label for="equip1selector">Equipe 1 :</label>
                        <select id="equip1selector" name="Equipe1" onchange="equip1Handler(value);" required><option value="">Equipe N°1</option>
                            <?php 
                                if(isset($clubs))
                                {
                                    $index = 1;
                                    foreach($clubs as $club)
                                    {
                                        echo "<option id='equip1opt".$index."' value=".$club['IdClub'].">".$club['NomClub']."</option>";
                                        $index++;
                                    }
                                }
                            ?>
                        </select>
                    </div>

                    <div id="equipe2">
                        <label for="equip2selector">Equipe 2 :</label>
                        <select id="equip2selector" name="Equipe2" onchange="equip2Handler(value);" required><option value="">Equipe N°2</option>
                            <?php 
                                if(isset($clubs))
                                {
                                    $index = 1;
                                    foreach($clubs as $club)
                                    {                           
                                        echo "<option id='equip2opt".$index."' value=".$club['IdClub'].">".$club['NomClub']."</option>";
                                        $index++;
                                    }
                                }
                            ?>
                        </select>
                    </div>
                </div>

                <!--Stadium-->                   
                <div class="football_player_content_subsection" id="Stade">
                    <label for="inputStadium">Stade :</label>
                    <input type="text" name="Stade" placeholder="Renseigner le stade" id="inputStadium" required>
                </div>

            </div>
        
        
<!--Referees-->
            <div class="football_player_content_section">
                <h2>Arbitres</h2>

                <!--Main Referee-->
                <div class="football_player_content_subsection" id="arbitrePrinc">

                    <label for="arbitrePrincSelector">Arbitre principal :</label>
                    <select id="arbitrePrincSelector" name="ArbitrePrinc" onchange="arbitrePrincHandler(value);"  required><option value="">Arbitre principal</option>
                        <?php
                            if(isset($arbitres))
                            {
                                $index = 1;
                                foreach($arbitres as $arbitre)
                                {                           
                                    echo "<option id='arbitrePrincOpt".$index."' value=".$arbitre['IdArbitre'].">".$arbitre['NomArbitre']."</option>";
                                    $index++;
                                }
                            }
                        ?>
                    </select>

                </div>

                <!--Assistant Referees-->            
                <div class="football_player_content_subsection" id="arbitreAss1">
                    <label for="arbitreAssSelector1">Arbitre assistant 1 :</label>
                    <select id="arbitreAssSelector1" name="ArbitreAss1" onchange="arbitreAss1Handler(value);" required><option value="">Arbitre assistant 1</option>
                        <?php 
                            if(isset($arbitres))
                            {
                                $index = 1;
                                foreach($arbitres as $arbitre)
                                {                           
                                    echo "<option id='arbitreAss1Opt".$index."' value=".$arbitre['IdArbitre'].">".$arbitre['NomArbitre']."</option>";
                                    $index++;
                                }
                            }
                        ?>
                    </select>
                </div>                
                    
                <div class="football_player_content_subsection" id="arbitreAss2">
                    <label for="arbitreAssSelector2">Arbitre assistant 2 :</label>
                    <select id="arbitreAssSelector2" name="ArbitreAss2" onchange="arbitreAss2Handler(value);" required><option value="">Arbitre assistant 2</option>
                        <?php 
                            if(isset($arbitres))
                            {
                                $index = 1;
                                foreach($arbitres as $arbitre)
                                {                           
                                    echo "<option id='arbitreAss2Opt".$index."' value=".$arbitre['IdArbitre'].">".$arbitre['NomArbitre']."</option>";
                                    $index++;
                                }
                            }
                        ?>
                    </select>
                </div>
                    
            </div>

<!--Send email-->
            <div class="football_player_content_section">
                <input type="checkbox" id="scales" name="scales" unchecked>
                <label for="scales">Envoyer un mail aux entraineurs des équipes sélectionnées</label>
                <a href = "mailto: abc@example.com">Send Email</a>
            </div>

<!--Submit button-->
            <input type="submit" value="Valider la feuille de match" class="submit_button" name="submit_button">
        </form> 
    </div>

    <script src="CreateMatchSheet.js"></script>

</body>

<footer>
    <?php
        include("footer.html");
    ?>
</footer>

</html>