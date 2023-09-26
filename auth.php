<?php

    require "utils.php";
    init_php_session();

    if(is_logged())
    {
        header("location: index.php");
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/style.css"/>
    <title>Page d'Accueil</title>
</head>
<body>
    <div class="container">
        <nav id="navbar">
            <div id="Header_Logo">
                <img src="./img/logo.png">
                <p>Footclick</p>
            </div>
            
            <ul>
                <li><button class="btn" id="displayForm">Espace Organisateur</button></li>
                <li><button class="btn" id="displayFormTrainer">Espace Entraineur</button></li>
            </ul>
        </nav>

        <section>
            <div class="sec-container">
                <div class="form-wrapper">
                    <div class="card">
                        <div id="card-title">Espace Organisateur</div>
                        <div class="card-header">
                            <div id="forLogin" class="form-header active">Se Connecter</div> 
                            <div id="forRegister" class="form-header">S'inscrire</div>
                        </div>
                        <div class="card-body" id="formContainer">
                            <form method="POST" action="processUser.php" id="loginForm">
                                <input type="text" name="username" class="form-control" placeholder="@utilisateur" required>
                                <input type="password" name="mdp" class="form-control" placeholder="@Mot de Passe" required>
                                <input type="hidden" id="boolAdminLog" name="admin" value="" />
                                <input type="hidden" name="logOrSign" value="login" />
                                <input type="submit" class="formButton" value="Connexion">
                                
                            </form>

                            <form method="POST" action="processUser.php" id="registerForm" class="toggleForm">
                                <p class="errorField" id="fnError" style="display: none">Lettres majuscules et minuscules et "-" uniquement.</p>
                                <input type="text" id="fnInput" name="nom" class="form-control" placeholder="Nom" required>
                                <p class="errorField" id="lnError" style="display: none">Lettres majuscules et minuscules et "-" uniquement.</p>
                                <input type="text" id="lnInput" name="prenom" class="form-control" placeholder="Prénom" required>
                                <p class="errorField" id="userNameError" style="display: none">Lettres, chiffres et '-_.' uniquement.</p>
                                <input type="text" id="usernameInput" name="identifiant" class="form-control" placeholder="Identifiant" required>
                                <p class="errorField" id="mailError" style="display: none">Adresse mail invalide</p>
                                <input type="email" id="mailInput" name="mail" class="form-control" placeholder="Adresse mail" required>
                                <p class="errorField" id="telError" style="display: none">10 chiffres Ex: 0600000000</p>
                                <input type="tel" id="telInput" name="telephone"class="form-control" placeholder="Numéro de téléphone" required>
                                <p class="errorField" id="pwdError" style="display: none">Message d'erreur du mot de passe</p>
                                <input type="password" id="pwd" name="mdp" class="form-control" id="mdp" placeholder="@Mot de Passe" required>
                                <input type="password" id="cpwd" name="confirmMdp" class="form-control" id="cmdp" placeholder="@Confirmer Mot de Passe" required>
                                <input style="margin-bottom: 20px;" type="checkbox" onclick="show_Password()">Afficher le mot de passe
                                <input type="password" id="codeAdmin" name="createAdmin" class="form-control" placeholder="Code de création Administrateur" required>
                                <input type="hidden" id="boolAdmin" name="admin" value="" />
                                <input type="hidden" name="logOrSign" value="signin" />
                                <input type="submit" class="formButton" id="registerButton">
                            </form>    
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </div>
        
    <script src="authentification.js"></script>
</body>

<footer>
    <?php
        include("footer.html")
    ?>
</footer>



</html>
