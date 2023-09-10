<!-----------------VERIFIER PHP ICI----------------->
<?php
    require("connectDB.php");
    require("Crud.php");
    require("utils.php");

    $db = connect();

    if(isset($_GET['idFeuille']) && intval($_GET['idFeuille']))
    {
        $globalsInfos = GlobalsInfosMatch($db, $_GET["idFeuille"]);
        $infosMatchs = Get_Match_infos($db, $_GET['idFeuille']);
        //On cherche dans la table de resultats de match si on a une 
        //feuille de resultats avec pour IdFeuilledeMatch notre $get
        $Resultats = Get_Feuille_Resultats($db, $_GET['idFeuille']);
        //si on a une feuille de résultats, alors on stocke son Id dans Update,
        $update = (count($Resultats) == 0 ? "0" : $Resultats[0]['IdResultatMatch']);
        //On récupère les évenements dans 3 tableaux différents
        $buts = Get_Match_Buts($db, $_GET['idFeuille']);
        $changements = Get_Match_Changements($db, $_GET['idFeuille']);
        $cartons = Get_Match_Cartons($db, $_GET['idFeuille']);
        //On récupère les joueurs dans un tableau 
        //et on prépare à l'avance le sélecteur 
        $joueurs = Get_Match_Players($db, $_GET['idFeuille']);
        $equipe2players = '';
        $equipe1players = '';
        //Construction des listes de joueurs
        foreach($joueurs as $joueur)
        {       
            if($joueur['IdEquipe'] == $infosMatchs['IdEquipe1'])
            {
                $equipe1players = $equipe1players."<option value=".$joueur["IdJoueur"].">".$joueur['Nom']." ".$joueur['Prenom']." (".$joueur['NomClub'].")</option>";
            }
            else
            {
                $equipe2players = $equipe2players."<option value=".$joueur["IdJoueur"].">".$joueur['Nom']." ".$joueur['Prenom']." (".$joueur['NomClub'].")</option>";
            }
        }
    }
    else
    {
        header("location: DisplayAndRedirect.php?result=KO");
    }
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style2.css"/>
    <link rel="stylesheet" href="ResultatsMatch.css"/>
<!-----------------TITLE A COMPLETER----------------->
    <title>Resultats du Match</title>
</head>

<!-- MANQUE HEADER AVEC LOGO FFF -->

<body>
<script>
    var players = <?php echo json_encode($joueurs);?>;
    var equipe1 = <?php echo json_encode($equipe1players);?>;
    var equipe2 = <?php echo json_encode($equipe2players);?>;
</script>
<!--Football Player Image-->
    <div class="football_player_image_container">
        <img src="img/Football_player.png" alt="Joueur de foot tirant dans un ballon" class="football_player_image">
    </div>

<!--Container for Football Player's page, here: "TITRE  H1"---------------------->
    <div class="football_player_content_container">

<!-----------------TITLE A COMPLETER----------------->
        <h1>Résultats du Match</h1>


<!-----------------SECTION 1----------------->       
            <div class="football_player_content_section">
                <h2><?php echo $globalsInfos;?></h2>

                <!--  //on appelle notre procédure avec notre $get update
                    //si il est à 0, alors on a pas de résulat, donc la procédure fait un insert
                    //sinon on a un resultat dont l'id est $update, alors on va update ce résultat-->
                <form action=<?php echo "InsertOrUpdateResults.php?update=".$update; ?> method="POST" id="">
<!-----------------SOUS SECTION 1.1-----------------> 
                <div class="football_player_content_subsection">
                    <p>Equipe Gagnante :</p>
                    <select name="EquipeGagnante" required>
                        <option value="">Equipe Gagnante</option>
                        <!-- Si on a un résultat déja rentré :
                            si la value de notre option (l'idEquipe) correspond à l'idEquipeGagnante, alors on la préselectionne-->
                        <option value=<?php echo "".$infosMatchs['IdEquipe1']." "; if($update != "0"){if($Resultats[0]['IdEquipeGagnante'] == $infosMatchs['IdEquipe1']){echo "selected";}}?>> <?php echo $infosMatchs['Equipe1']; ?></option>
                        <option value=<?php echo "".$infosMatchs['IdEquipe2']." "; if($update != "0"){if($Resultats[0]['IdEquipeGagnante'] == $infosMatchs['IdEquipe2']){echo "selected";}}?>> <?php echo $infosMatchs['Equipe2']; ?></option>
                        <!--<option value='".$infosMatchs['IdEquipe2']."'>".$infosMatchs['Equipe2']."</option>";?>-->
                        
                    </select>

                    <br>
                    <p>Score équipe gagnante : </p>
                     <!-- Si on a un résultat déja rentré :
                            on met value de l'input = notre résultat, sinon ="" -->
                    <input type="number" name="scoreEquipeGagnante" class="numberInput" value=<?php if(count($Resultats) != 0){echo $Resultats[0]['ScoreEquipeGagnante'];}else{echo "";} ?> required>
                    <p>Score équipe perdante : </p>
                    <input type="number" name="scoreEquipePerdante" class="numberInput" value=<?php if(count($Resultats) != 0){echo $Resultats[0]['ScoreEquipePerdante'];}else{echo "";} ?> required><br>
                    <p>Durée du Match (minutes) : </p>
                    <input type="number" name="DureeMatch" class="numberInput" value=<?php if(count($Resultats) != 0){echo $Resultats[0]['DureeTotale'];}else{echo "";} ?> required>
                
                    <input type="hidden" name="idFeuille" value=<?php echo $_GET['idFeuille']; ?>>
                <input type="submit" value="Valider les scores" class="submit_button">
                
                </form>
                </div>
            </div>

<!-----------------EVENEMENTS-----------------> 
            <div class="football_player_content_section">
                <h2>Evenements du Match :</h2>

<!-----------------BUTS-----------------> 
                <div class="football_player_content_subsection">
                    <h2>Buts :</h2><br>
                    <!-- D'abord on display les Buts déjà rentrés -->
                    <?php 

                        if(count($buts) > 0)
                        {
                           foreach($buts as $but)
                            {
                                $csc = $but['contreSonCamp'] == true ? "contre son camp" : "";
                                echo '<div class="but">';
                                echo '<p>'.$but['NomClub'].' => But '.$csc.' de '.$but["nomButeur"].' '.$but["prenomButeur"].' à la '.$but["minute"].'ème minute </p>';
                                echo '<a href="deleteBut.php?idBut='.$but["IdBut"].'&IdMatch='.$_GET['idFeuille'].'" ><button>Supprimer</button></a></div>';
                            }   
                        }
                    ?>
                    <!-- Puis un formulaire pour en rajouter un !-->
                     <!-- Bouton "ajouter un carton" pour faire apparaitre le formulaire !-->
                    <button class="addButton" onclick="show_AjoutBut_form()">Ajouter un But</button>
                    <div id="AjoutBut">
                        <form method="POST" action="AddBut.php" id="ajoutButForm">
                            <input type="hidden" name="IdMatch" value=<?php echo $_GET['idFeuille'];?>>
                            <select name="equipe" onchange="changeJoueurSelection(value)" id="" required>
                                <option value="">Equipe</option>
                                <option value="1"><?php echo $infosMatchs['Equipe1']?></option>
                                <option value="2"><?php echo $infosMatchs['Equipe2']?></option>
                            </select>
                            <select name="buteur" id="buteurSelector" required>
                                <option value="">Buteur : </option>
                            </select>
                            <p>But contre son camp ? </p><input type="checkbox" name="ContreSonCamp" id="ButCheckBox">
                            <input type="hidden" name="ContreSonCamp" id="ButCheckBoxValue" value="">
                            <br>
                            <p>Moment du Match (Minutes) : </p>
                            <input type="number" name="minute" class="numberInput" required>
                            <input type="submit" value="Valider le But" class="submit_button">
                        </form>
                    </div>
                </div>

<!-----------------CHANGEMENTS----------------->                  
                <div class="football_player_content_subsection">
                    <h2>Changements :</h2><br>
                    <!-- D'abord on display les Changements déjà rentrés -->
                    
                    <?php
                        if(count($changements) > 0)
                        {
                            foreach($changements as $changement)
                            {
                                echo '<div class="changement">';
                                echo '<p>'.$changement['NomClub'].' => Sortie de '.$changement["joueurSortant"].' remplacé par '.$changement["joueurEntrant"].' à la '.$changement["minute"].'ème minute </p>';
                                echo '<a href="deleteChangement.php?idChangement='.$changement["IdRemplacement"].'&IdMatch='.$_GET['idFeuille'].'" ><button>Supprimer</button></a></div>';
                            }   
                        }
                    ?>
                    <!-- Puis un formulaire pour en rajouter un !-->
                     <!-- Bouton "ajouter un changement" pour faire apparaitre le formulaire !-->
                    <br><button class="addButton" onclick="show_AjoutChangement_form()">Ajouter un changement</button>
                    <div id="AjoutChangement">
                        <form action="AddChangement.php" method="POST" id="ajoutChangementForm">
                            <input type="hidden" name="IdMatch" value=<?php echo $_GET['idFeuille'];?>>
                            <select name="equipe" onchange="changeJoueurChangementSelection(value)" id="" required>
                                <option value="">Equipe</option>
                                <option value="1"><?php echo $infosMatchs['Equipe1']?></option>
                                <option value="2"><?php echo $infosMatchs['Equipe2']?></option>
                            </select>
                            <select name="joueurEntrant" id="joueurEntrantSelector" required>
                                <option value="">Joueur Entrant</option>
                            </select>
                            <select name="joueurSortant" id="joueurSortantSelector" required>
                                <option value="">Joueur Sortant</option>
                            </select><br>
                            <p>Moment du Match (Minutes) : </p>
                            <input type="number" name="minute" class="numberInput" required>
                            <input type="submit" value="Valider le Changement" class="submit_button">
                        </form>
                    </div>
                </div>

<!-----------------CARTONS----------------->    
                <div class="football_player_content_subsection">
                    <h2>Cartons :</h2><br>
                    <!-- D'abord on display les Cartons déjà rentrés -->
                    <?php
                        if(count($cartons) > 0)
                        {
                            foreach($cartons as $carton)
                            {
                                echo '<div class="carton">';
                                echo '<p>'.$carton['NomClub'].' => '.$carton["NomCarton"].' pour '.$carton["joueurSanctionne"].' à la '.$carton["minute"].'ème minute </p>';
                                echo '<a href="deleteCarton.php?idCarton='.$carton["IdCarton"].'&IdMatch='.$_GET['idFeuille'].'" ><button>Supprimer</button></a></div>';
                            }   
                        }
                    ?>
                    <!-- Puis un formulaire pour en rajouter un !-->
                    <!-- Bouton "ajouter un carton" pour faire apparaitre le formulaire !-->
                    <button class="addButton" onclick="show_AjoutCarton_form()">Ajouter un carton</button>
                    <div id="AjoutCarton">
                        <form action="AddCarton.php" method="POST" id="ajoutCartonForm">
                            <input type="hidden" name="IdMatch" value=<?php echo $_GET['idFeuille'];?>>
                            <select name="carton" id="" required>
                                <option value="">Type de Carton</option>
                                <option value="1">Carton Jaune</option>
                                <option value="2">Carton Rouge</option>
                            </select>
                            <select name="equipe" onchange="changeJoueurSanctionneSelection(value)" id="" required>
                                <option value="">Equipe</option>
                                <option value="1"><?php echo $infosMatchs['Equipe1']?></option>
                                <option value="2"><?php echo $infosMatchs['Equipe2']?></option>
                            </select>
                            <select name="joueurSanctionne" id="JoueurSanctionneSelector" required>
                                <option value="">Joueur Sanctionné</option>
                            </select><br>
                            <p>Moment du Match (Minutes) : </p>
                            <input type="number" name="minute" class="numberInput" required>
                            <input type="submit" value="Valider le Carton" class="submit_button">
                        </form>
                    </div>
                </div>

            </div>

<!--Submit button-->
        <form action="ValiderResultats.php" method="POST" id="validerResultatsForm">
        
        <input type="hidden" name="IdMatch" value=<?php echo $_GET['idFeuille'];?>>
        <input type="submit" value="Valider la feuille de match" class="submit_button">
        </form> 
        <button class="addButton" onclick="window.print()">Imprimer la page</button>
    </div>
    <script src="resultatsMatch.js"></script>
</body>

<footer>
    <?php
        //include("footer.html")
    ?>
</footer>

</html>