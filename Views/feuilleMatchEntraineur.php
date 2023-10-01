<?php
    require "../Librairies/connectDB.php";
    require "../Librairies/Crud.php";
    require "../Librairies/utils.php";

    init_php_session();
    grant_access(false);

    $db = connect();

    if(isset($_GET["idFeuille"]))
    {
        //a remplacer par la récupération identraineur depuis la session
        $identraineur = $_SESSION["IdEntraineur"];
        $globalsInfos = GlobalsInfosMatch($db, $_GET["idFeuille"]);
        $idFeuilleEntraineur = Get_Feuille_Entraineur($db, $_GET["idFeuille"], $identraineur);
        $players = Get_Players_From_Trainer($db, $identraineur);
        $postes = Get_All_Postes($db);
        $postesOptions = "<option value=''>poste</option>";
        if($postes != null)
        {
            foreach($postes as $poste)
            {   
                $postesOptions = $postesOptions."<option value=".$poste["IdPoste"].">".$poste["NomPoste"]."</option>";
            }
        }
        if($players != null)
        {
            $playersOptions = "<option value=''>Joueur</option>";
            foreach($players as $player)
            {   
                $playersOptions = $playersOptions."<option value=".$player["IdJoueur"].">".$player["Nom"]." ".$player["Prenom"]."</option>";
            }
        }
    }
    else{
        header("location: ../Views/DisplayAndRedirect.php?result=KO");
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

    <title>Feuille Entraineur</title>
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
        <img src="../img/Football_player.png" alt="Joueur de foot tirant dans un ballon" class="football_player_image">
    </div>


    <div class="football_player_content_container">


        <h1>Feuille Entraineur</h1>


    
            <div class="football_player_content_section">
                <h2><?php echo $globalsInfos;?></h2>

 
                <div class="football_player_content_subsection">
                    
                </div>

            </div>

        <form action=<?php echo "../Back/updateTrainerSheet.php?idFeuilleM=".$_GET["idFeuille"]."&idFeuilleE=".$idFeuilleEntraineur;?> method="POST" class="PlayersList" >

            <div class="football_player_content_section">
                <h2>Joueurs Titulaires</h2>

 
                
                    <ul>
                        <li id="player1">
                            <select id="nom" name="idPlayer1" required>
                                <?php echo $playersOptions;?>
                            </select>
                            <select id="poste1" name="postePlayer1" required>
                                <?php echo $postesOptions;?>
                            </select>
                        </li>
                        <li id="player2">
                            <select id="nom" name="idPlayer2" required>
                            <?php echo $playersOptions;?>
                            </select>
                            <select id="poste" name="postePlayer2" required>
                                <?php echo $postesOptions;?>
                            </select>
                        </li>
                        <li id="player3">
                            <select id="nom" name="idPlayer3" required>
                            <?php echo $playersOptions;?>
                            </select>
                            <select id="poste" name="postePlayer3" required>
                                <?php echo $postesOptions;?>
                            </select>
                        </li>
                        <li id="player4">
                            <select id="nom" name="idPlayer4" required>
                                <?php echo $playersOptions;?>
                            </select>
                            <select id="poste" name="postePlayer4" required>
                                <?php echo $postesOptions;?>
                            </select>
                        </li>
                        <li id="player5">
                            <select id="nom" name="idPlayer5" required>
                                <?php echo $playersOptions;?>
                            </select>
                            <select id="poste" name="postePlayer5" required>
                                <?php echo $postesOptions;?>
                            </select>
                        </li>
                        <li id="player6">
                            <select id="nom" name="idPlayer6" required>
                                <?php echo $playersOptions;?>
                            </select>
                            <select id="poste" name="postePlayer6" required>
                                <?php echo $postesOptions;?>
                            </select>
                        </li>
                        <li id="player7">
                            <select id="nom" name="idPlayer7" required>
                                <?php echo $playersOptions;?>
                            </select>
                            <select id="poste" name="postePlayer7" required>
                                <?php echo $postesOptions;?>
                            </select>
                        </li>
                        <li id="player8">
                            <select id="nom" name="idPlayer8" required>
                                <?php echo $playersOptions;?>
                            </select>
                            <select id="poste" name="postePlayer8" required>
                                <?php echo $postesOptions;?>
                            </select>
                        </li>
                        <li id="player9">
                            <select id="nom" name="idPlayer9" required>
                                <?php echo $playersOptions;?>
                            </select>
                            <select id="poste" name="postePlayer9" required>
                                <?php echo $postesOptions;?>
                            </select>
                        </li>
                        <li id="player10">
                            <select id="nom" name="idPlayer10" required>
                                <?php echo $playersOptions;?>
                            </select>
                            <select id="poste" name="postePlayer10" required>
                                <?php echo $postesOptions;?>
                            </select>
                        </li>
                        <li id="player11">
                            <select id="nom" name="idPlayer11" required>
                                <?php echo $playersOptions;?>
                            </select>
                            <select id="poste" name="postePlayer11" required>
                                <?php echo $postesOptions;?>
                            </select>
                        </li>
                    </ul>
                

            </div>
        

            <div class="football_player_content_section">
                <h2>Joueurs Remplaçants</h2>


                <ul>
                    <li class="substitute">
                        <select id="substitute1" name="substitute1" required>
                            <?php echo $playersOptions;?>
                        </select>
                    </li>
                    <li class="substitute">
                        <select id="substitute2" name="substitute2" required>
                            <?php echo $playersOptions;?>
                        </select>
                    </li>
                    <li class="substitute">
                        <select id="substitute3" name="substitute3" required>
                            <?php echo $playersOptions;?>
                        </select>
                    </li>
                    <li class="substitute">
                        <select id="substitute4" name="substitute4">
                            <?php echo $playersOptions;?>
                        </select>
                    </li>
                    <li class="substitute">
                        <select id="substitute5" name="substitute5">
                            <?php echo $playersOptions;?>
                        </select>
                    </li>
                    <li class="substitute">
                        <select id="substitute6" name="substitute6">
                            <?php echo $playersOptions;?>
                        </select>
                    </li>
                </ul>
                    
            </div>
            <div class="football_player_content_section">
                <h2>Capitaine</h2>
                    <select id="capitaine" name="capitaine" required>
                        <?php echo $playersOptions;?>
                    </select>
                <h2>Suppléant</h2>
                    <select id="substitute6" name="suppleant" required>
                        <?php echo $playersOptions;?>
                    </select>
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