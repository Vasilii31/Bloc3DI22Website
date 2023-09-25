<?php
    require("connectDB.php");
    require("Crud.php");
    require("utils.php");

    init_php_session();
    if(!is_logged())
    {
        header("location: auth.php");
        return;
    }

    $db = connect();
    if(isset($_GET["id"]) && intval($_GET["id"]) > 0)
    {
        
        $historiqueMatch = Get_Details_Match_Termine($db, $_GET["id"]);
        $Resultats = Get_Feuille_Resultats($db, $_GET['id']);
        $vainqueur = Get_team($db, $Resultats[0]["IdEquipeGagnante"]);
        $buts = Get_Match_Buts($db, $_GET['id']);
        $changements = Get_Match_Changements($db, $_GET['id']);
        $cartons = Get_Match_Cartons($db, $_GET['id']);
        if($historiqueMatch == false)
        {
            header("location: /DisplayAndRedirect?result=KO");
        }
    }
    else
    {
        header("location: /DisplayAndRedirect?result=KO");
    }
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style2.css"/>
    <link rel="stylesheet" href="detailsMatch.css"/>
<!-----------------TITLE A COMPLETER----------------->
    <title>Détails du match</title>
</head>

<header>
    <?php
        include("header.php");
    ?>
</header>

<body>

    <div id="printable">
<!--Container for Football Player's page, here: "TITRE  H1"---------------------->
    <div class="football_player_content_container">
        
<!-----------------TITLE A COMPLETER----------------->
        <h1>Match <?php echo $historiqueMatch["Equipe1"];?> contre <?php echo $historiqueMatch["Equipe2"];?></h1>


<!-----------------SECTION 1----------------->       
            <div class="football_player_content_section">
                <!--<div id="dateEtStade">-->
                    <h2>Le <?php echo date("d-m-Y", strtotime($historiqueMatch["DateRencontre"])); ?></h2><h2> Stade : <?php echo $historiqueMatch["Stade"]; ?></h2>
                <!--</div>-->
                <!-----------------SOUS SECTION 1.1-----------------> 
                <div id= "scoreEtVainqueur">
                    <h2>Score: <?php echo $Resultats[0]["ScoreEquipeGagnante"]."-".$Resultats[0]["ScoreEquipePerdante"]; ?></h2>
                    <h2>Victoire de : <?php echo $vainqueur["NomEquipe"];?></h2>
                </div>
            </div>

<!-----------------SECTION 2-----------------> 
            <div class="football_player_content_section">
                <h2>Evenements du match :</h2>
                <p class="eventCat">Buts :</p><br>
                <?php 

                        if(count($buts) > 0)
                        {
                           foreach($buts as $but)
                            {
                                $csc = $but['contreSonCamp'] == true ? "contre son camp" : "";
                                //echo '<div class="but">';
                                echo '<p>'.$but['NomClub'].' => But '.$csc.' de '.$but["nomButeur"].' '.$but["prenomButeur"].' à la '.$but["minute"].'ème minute </p>';
                               // echo '<a href="deleteBut.php?idBut='.$but["IdBut"].'&IdMatch='.$_GET['idFeuille'].'" ><button>Supprimer</button></a></div>';
                            }   
                        }
                    ?>
                <br>
                <p class="eventCat">Changements :</p><br>
                <?php
                        if(count($changements) > 0)
                        {
                            foreach($changements as $changement)
                            {
                                //echo '<div class="changement">';
                                echo '<p>'.$changement['NomClub'].' => Sortie de '.$changement["joueurSortant"].' remplacé par '.$changement["joueurEntrant"].' à la '.$changement["minute"].'ème minute </p>';
                                //echo '<a href="deleteChangement.php?idChangement='.$changement["IdRemplacement"].'&IdMatch='.$_GET['idFeuille'].'" ><button>Supprimer</button></a></div>';
                            }   
                        }
                    ?> 
                <br>               
                <p class="eventCat">Cartons :</p> 
                <br>               
                <?php
                        if(count($cartons) > 0)
                        {
                            foreach($cartons as $carton)
                            {
                                //echo '<div class="carton">';
                                echo '<p>'.$carton['NomClub'].' => '.$carton["NomCarton"].' pour '.$carton["joueurSanctionne"].' à la '.$carton["minute"].'ème minute </p>';
                                //echo '<a href="deleteCarton.php?idCarton='.$carton["IdCarton"].'&IdMatch='.$_GET['idFeuille'].'" ><button>Supprimer</button></a></div>';
                            }   
                        }
                    ?>
            </div>
            
    </div>
    
    </div>
    <button class="addButton" id="printBtn" onclick="printMatch()">Imprimer la page</button>
    <script src="detailsMatch.js"></script>
</body>

<footer>
    <?php
        include("footer.html")
    ?>
</footer>

</html>
