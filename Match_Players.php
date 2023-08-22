<?php
    require "connectDB.php";
    require "Crud.php";
    require "utils.php";

    $db = connect();

    if(isset($_GET["idFeuille"]))
    {
        $globalsInfos = GlobalsInfosMatch($db, $_GET["idFeuille"]);
        $postes = Get_All_Positions($db);
        $postesOptions = "<option value=''>poste</option>";
        if($postes != null)
        {

            foreach($postes as $poste)
            {   
                $postesOptions = $postesOptions."<option value=".$poste["IdPoste"].">".$poste["NomPoste"]."</option>";
            }
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
    <title>Feuille Entraineur</title>
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
        <h1>Feuille Entraineur</h1>


<!-----------------SECTION 1----------------->       
            <div class="football_player_content_section">
                <h2><?php echo $globalsInfos;?></h2>

<!-----------------SOUS SECTION 1.1-----------------> 
                <div class="football_player_content_subsection">
                    <p>Paragraphe</p>
                </div>

            </div>

        <form class="PlayersList">
<!-----------------SECTION 2-----------------> 
            <div class="football_player_content_section">
                <h2>Joueurs Titulaires</h2>

<!-----------------SOUS SECTION 2.1-----------------> 
                
                    <ul>
                        <li id="player1">
                            <select id="nom" name="nom" required>
                                <option value="">Joueur 1</option>
                            </select>
                            <select id="poste1" name="poste" required>
                                <?php echo $postesOptions;?>
                            </select>
                        </li>
                        <li id="player2">
                            <select id="nom" name="nom" required>
                                <option value="">Joueur 1</option>
                            </select>
                            <select id="poste" name="poste" required>
                                <?php echo $postesOptions;?>
                            </select>
                        </li>
                        <li id="player3">
                            <select id="nom" name="nom" required>
                                <option value="">Joueur 1</option>
                            </select>
                            <select id="poste" name="poste" required>
                                <?php echo $postesOptions;?>
                            </select>
                        </li>
                        <li id="player4">
                            <select id="nom" name="nom" required>
                                <option value="">Joueur 1</option>
                            </select>
                            <select id="poste" name="poste" required>
                                <?php echo $postesOptions;?>
                            </select>
                        </li>
                        <li id="player5">
                            <select id="nom" name="nom" required>
                                <option value="">Joueur 1</option>
                            </select>
                            <select id="poste" name="poste" required>
                                <?php echo $postesOptions;?>
                            </select>
                        </li>
                        <li id="player6">
                            <select id="nom" name="nom" required>
                                <option value="">Joueur 1</option>
                            </select>
                            <select id="poste" name="poste" required>
                                <?php echo $postesOptions;?>
                            </select>
                        </li>
                        <li id="player7">
                            <select id="nom" name="nom" required>
                                <option value="">Joueur 1</option>
                            </select>
                            <select id="poste" name="poste" required>
                                <?php echo $postesOptions;?>
                            </select>
                        </li>
                        <li id="player8">
                            <select id="nom" name="nom" required>
                                <option value="">Joueur 1</option>
                            </select>
                            <select id="poste" name="poste" required>
                                <?php echo $postesOptions;?>
                            </select>
                        </li>
                        <li id="player9">
                            <select id="nom" name="nom" required>
                                <option value="">Joueur 1</option>
                            </select>
                            <select id="poste" name="poste" required>
                                <?php echo $postesOptions;?>
                            </select>
                        </li>
                        <li id="player10">
                            <select id="nom" name="nom" required>
                                <option value="">Joueur 1</option>
                            </select>
                            <select id="poste" name="poste" required>
                                <?php echo $postesOptions;?>
                            </select>
                        </li>
                        <li id="player11">
                            <select id="nom" name="nom" required>
                                <option value="">Joueur 1</option>
                            </select>
                            <select id="poste" name="poste" required>
                                <?php echo $postesOptions;?>
                            </select>
                        </li>
                    </ul>
                

            </div>
        
        
<!-----------------SECTION 3----------------->
            <div class="football_player_content_section">
                <h2>Joueurs Remplaçants</h2>

<!-----------------SOUS SECTION 3.1-----------------> 
                <ul>
                    <li class="substitute">
                        <select id="substitute1" name="substitute1" required>
                            <option value="">Joueur 1</option>
                        </select>
                    </li>
                    <li class="substitute">
                        <select id="substitute2" name="substitute2" required>
                            <option value="">Joueur 1</option>
                        </select>
                    </li>
                    <li class="substitute">
                        <select id="substitute3" name="substitute3" required>
                            <option value="">Joueur 1</option>
                        </select>
                    </li>
                </ul>
                    
            </div>
<!--Send email-->
            <div class="football_player_content_section">
                <input type="checkbox" id="scales" name="scales" unchecked>
                <label for="scales">Envoyer un mail aux entraineurs des équipes sélectionnées</label>
                <a href = "mailto: abc@example.com">Send Email</a>
            </div>

<!--Submit button-->
            <input type="submit" value="Valider la feuille de match" class="submit_button">
            

        </form> 

    </div>
    <!--Pas encore de script !<script src="Match_Players.js"></script>-->
</body>

<footer>
    <?php
        include("footer.html")
    ?>
</footer>

</html>