<?php
    require("../Librairies/connectDB.php");
    //require("Crud.php");
    require("../Librairies/utils.php");

    init_php_session();

    if(!is_logged())
    {
        header("location: /auth.php");
    }

    $db = connect();
    $admin = is_admin();
    
    if(isset($_SESSION["IdEntraineur"]) && $_SESSION["IdEntraineur"] != "")
    {
        $matchsAcompleter = Get_Matches_To_Complete($db, $_SESSION["IdEntraineur"]);
        $historiqueMatch = Get_Historiques_Team_Matches($db, $_SESSION["IdEntraineur"]);
        //$matchsAvenir = Get_Incoming_Matches($db, $_SESSION["IdEntraineur"]);
    }
    elseif(is_admin())
    {
        $attenteEntraineurs = Get_Matchs_Attente_Entraineurs($db);
        $attenteResultats = Get_Matchs_Attente_Resultats($db);
    }


 ?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="../css/indexStyle.css"/>
        <title>FootClick - Accueil</title>
    </head>
    <header>
        <?php
            include("header.php");
        ?>
    </header> 
    <body>

        <div class="indexPage_container">
            <div class="football_player_content_container">
                <!--AFFICHAGE ENTRAINEUR-->
                <?php if(!is_admin()):   ?>
                    <h1>Prochains matchs de mon équipe à compléter</h1>

                    <?php
                        if(count($matchsAcompleter) == 0)
                        {
                            echo "<h2>Aucun match à compléter pour l'instant.</h2>";
                        }
                        else
                        {
                            foreach($matchsAcompleter as $match)
                            {
                                echo '<div class="Match"> 
                                <p>Le : '.date('d-m-Y', strtotime($match["DateRencontre"])).' à '.$match["Stade"].' &bull; '.$match["Equipe1"].' contre '.$match["Equipe2"].'</p>
                                <button><a href="feuilleMatchEntraineur.php?idFeuille='.$match["IdFeuille"].'" class="bouton">Compléter</a></button>
                                </div>';
                                // echo '<p>'.$match["Stade"].'</p>';
                                // echo '<p>'.$match["monEquipe"].'</p>';
                                // echo '<p>'.$match["equipeAdverse"].'</p></a>';
                            }
                        }

                    
                    ?>
                <!--AFFICHAGE ADMINISTRATEUR-->
                <?php else:?>
                    <h1>Matchs en attente de complétion par les entraineurs</h1>

                    <?php
                        if(count($attenteEntraineurs) == 0)
                        {
                            echo "<h2>Aucun match en attente de complétion.</h2>";
                        }
                        else
                        {
                            foreach($attenteEntraineurs as $match)
                            {
                                echo '<div class="Match">
                                <p>Le : '.date('d-m-Y', strtotime($match["DateRencontre"])).' à '.$match["Stade"].' &bull; '.$match["equipe1"].' contre '.$match["equipe2"].'</p>
                                </div>';
                                // echo '<p>'.$match["Stade"].' - </p>';
                                // echo '<p>'.$match["equipe1"].' contre '.$match["equipe2"].'</p></div>';
                            }
                        }

                    ?>
                <?php endif;?>
            </div>  

            <div class="football_player_content_container">
                <!--AFFICHAGE ADMINISTRATEUR-->
                <?php if(is_admin()):   ?>
                    <h1>Matchs terminés: En attente d'insertion de résultats</h1>
                    <?php
                        if(count($attenteResultats) == 0)
                        {
                            echo "<h2>Aucun match en attente d'insertion de résultat.</h2>";
                        }
                        else
                        {
                            foreach($attenteResultats as $match)
                            {
                                echo '<div class="Match">';
                                echo '<p>Le : '.date('d-m-Y', strtotime($match["DateRencontre"])).' à '.$match["Stade"].' &bull; '.$match["equipe1"].' contre '.$match["equipe2"].'</p>
                                <button><a href="ResultatsMatch.php?idFeuille='.$match["IdFeuille"].'" class="bouton">Compléter</a></button></div>';
                                // echo '<p>'.$match["Stade"].'</p>';
                                // echo '<p>'.$match["equipe1"].' contre '.$match["equipe2"].'</p></div></a>';
                            }
                        }
                    ?>
                <!--AFFICHAGE ENTRAINEUR-->
                <?php else:?>
                    <h1>Historique des Matchs de mon équipe</h1>
                    <?php
                        if(count($historiqueMatch) == 0)
                        {
                            echo "<h2>Aucun historique de match pour cette équipe.</h2>";
                        }
                        else
                        {
                            foreach($historiqueMatch as $feuilledematch)
                            {
                                echo '<div class="Match">';
                                
                                echo '<p>Le : '.$feuilledematch["DateRencontre"].' &bull; '.$feuilledematch["Equipe1"].' contre '.$feuilledematch["Equipe2"].'</p>';
                                
                                if($feuilledematch["MatchNul" == false])
                                {
                                    echo '<div class="score"><p class="win">'.$feuilledematch["ScoreEquipeGagnante"].'</p><p> - </p><p class="loss">'.$feuilledematch["ScoreEquipePerdante"].'</p></div>';
                                }
                                else
                                {
                                    echo '<div class="score"><p>'.$feuilledematch["ScoreEquipeGagnante"].' - '.$feuilledematch["ScoreEquipePerdante"].'</p></div>';
                                    
                                }
                                echo '
                                <button><a href=detailsMatch.php?id='.$feuilledematch["IdFeuille"]. ' class="bouton">Consulter</a></button>
                                </div>';
                            }
                        }
                    ?>
                <?php endif;?>    
            </div>
        </div>

    </body>
    <footer>
        <?php
            include("footer.html")
        ?>
    </footer>

    
</html>