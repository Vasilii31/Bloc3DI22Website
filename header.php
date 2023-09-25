
<link rel="stylesheet" href="./css/headerStyle.css"/>


<div id="header"  >
    <a href="index.php">
        <div id="Header_Logo">
            <img src="./img/logo.png">
        </div>
    </a>
    
    <div id="Header_Menu">
        <?php if(!is_admin()):  ?>
        <ul>
            <li>
                <div class="dropdown">
                    <button onclick="DropDownEquipe()" class="dropbtn">Mon Equipe</button>
                        <div id="DropdownEquipe" class="dropdown-content">
                            <a href="Trainer_Add_Player.php">Ajouter un joueur</a>
                            <a href="myTeam.php">Consulter mon équipe</a>
                        </div>
                </div>
            </li>
            <li>
                <div class="dropdown">
                    <button onclick="DropDownMatchsEntraineur()" class="dropbtn">Mes Matchs</button>
                        <div id="DropdownMatchEntraineur" class="dropdown-content">
                            <a href="#">Matchs à compléter</a>
                            <a href="#">Matchs complétés à venir</a>
                            <a href="#">Historique des matchs</a>
                        </div>
                </div>
            </li>
        </ul>
        <?php else:?>
            <ul>
            <li>
                <div class="dropdown">
                    <button onclick="DropDownEquipe()" class="dropbtn">Créer</button>
                        <div id="DropdownEquipe" class="dropdown-content">
                            <a href="Arbitre.php">Créer un arbitre</a>
                            <a href="CreationClub.php">Créer un Club</a>
                            <a href="CreationEquipe.php">Créer une équipe</a>
                            <a href="feuilleMatch.php">Créer un match</a>
                        </div>
                </div>
            </li>
            <li>
                <div class="dropdown">
                    <button onclick="DropDownGestionEntraineurs()" class="dropbtn">Gestion des Entraineurs</button>
                    <div id="DropDownGestionEntraineurs" class="dropdown-content">
                        <a href="inbox.php">Demandes utilisateur</a>
                        <a href="AttributionEntraineur.php">Attribuer un entraineur à une équipe</a>
                    </div>
                </div>
            </li>
            <li>
                <div class="dropdown">
                    <a href="historiqueMatch.php"><button onclick="" class="refbtn">Historique des Matchs</button></a>
                </div>
            </li>
        </ul> 
        <?php endif;?>
    </div>
    <ul>
        <li><?php echo $_SESSION["prenom"]." ".$_SESSION["nom"]; ?></li>
        <li>|</li>
        <li><a href="logOut.php">Déconnexion</a></li>
    </ul>
</div>

<script src="header.js"></script>