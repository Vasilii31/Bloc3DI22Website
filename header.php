
<link rel="stylesheet" href="headerStyle.css"/>


<div id="header">
    <div id="Header_Logo">LOGO</div>
    <div id="Header_Menu">
        <?php //if(!isAdmin()): 
            if($ok == 2):  ?>
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
                            <a href="#">Créer un club</a>
                            <a href="#">Créer une équipe</a>
                            <a href="feuilleMatch.php">Créer un match</a>
                        </div>
                </div>
            </li>
            <li>
                <div class="dropdown">
                    <a href="historiqueMatch.php"><button onclick="" class="refbtn">Historique des Matchs</button></a>
                </div>
            </li>
            <li>
                <div class="dropdown">
                    <a href="inbox.php"><button onclick="" class="refbtn">Demandes utilisateur</button></a>
                </div>
            </li>
        </ul> 
        <?php endif;?>
    </div>
    <ul>
        <li>Thierry Machin</li>
        <li>|</li>
        <li><a href="logOut.php">Déconnexion</a></li>
    </ul>
</div>

<script src="header.js"></script>