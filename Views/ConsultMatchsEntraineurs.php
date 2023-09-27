<?php
    require("../Librairies/connectDB.php");
    require("../Librairies/Crud.php");
    require("../Librairies/utils.php");

    init_php_session();
    grant_access(false);
    $db = connect();
    
    $idteam = Get_IDTeam_FromTrainer($db, $_SESSION["IdEntraineur"]);
    if($idteam == "")
    {
        header("./DisplayAndRedirect.php?result=KO");
        return;
    }

    switch($_GET["matchs"])
    {
        case "tocomplete":
            $matchs = Get_Matches_To_Complete($db, $_SESSION["IdEntraineur"]);
            $title = "Matchs à compléter";
            $none = "Aucun match à compléter pour l'instant.";
            break;
        case "completedIncoming":
            $matchs = Get_Matches_Completed_by_Trainer($db, $_SESSION["IdEntraineur"]);
            $title = "Matchs complétés à venir";
            $none = "Aucun match complété à venir.";
            break;
        case "archived":
            $matchs =  Get_Historiques_Team_Matches($db, $_SESSION["IdEntraineur"]);
            $title = "Historique de l'équipe";
            $none = "Aucun match en historique pour cette équipe";
            break;                   
    }
    var_dump($matchs);

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/inboxStyle.css"/>
    <link rel="stylesheet" href="../css/templateStyle.css"/>
    <link rel="stylesheet" href="../css/detailsMatchs.css"/>
<!-----------------TITLE A COMPLETER----------------->
    <title><?php echo $title; ?></title>
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
            <h2><?php echo $title; ?></h2>
                <div class="football_player_content_section">

                    <?php 
                    if(!is_null($matchs) && count($matchs) > 0)
                    {
                        foreach($matchs as $match)
                        {
                            if($_GET["matchs"] == "tocomplete")
                            {
                                echo '<a href="../Views/feuilleMatchEntraineur.php?idFeuille='.$match["idfeuille"].'">';
                            }
                            if($_GET["matchs"] == "archived")
                            {
                                echo '<a href="../Views/detailsMatch.php?id='.$match["IdFeuille"].'">';
                            }
                            echo '<div class="Match"><p>Le : '.date("d-m-Y", strtotime($match["DateRencontre"])).'</p>';
                            echo '<p>'.$match["Equipe1"].' contre '.$match["Equipe2"].'</p>';
                            if($_GET["matchs"] == "tocomplete")
                            {
                                echo '</a>';
                            }
                            if($_GET["matchs"] == "archived")
                            {
                                echo '</a>';
                            }
                            echo '</div>';
                            /*if($feuilledematch["MatchNul" == false])
                            {
                                echo '<div class="score"><p class="win">'.$feuilledematch["ScoreEquipeGagnante"].'</p><p>-</p>';
                                echo '<p class="loss">'.$feuilledematch["ScoreEquipePerdante"].'</p></div>';
                            }
                            else
                            {
                                echo '<div class="score"><p>'.$feuilledematch["ScoreEquipeGagnante"].'</p><p>-</p>';
                                echo '<p>'.$feuilledematch["ScoreEquipePerdante"].'</p></div>';
                            }
                            echo '</div></a>';*/
                        }
                    }
                    else
                        echo "<p>".$none."</p>";
                    ?>
                    </div>
            
                </div>

        </div>

</div>


    <script src="../jsScripts/acceuilPreConnexion.js"></script>
</body>

<footer>
    <?php
        include("footer.html")
    ?>
</footer>

</html>