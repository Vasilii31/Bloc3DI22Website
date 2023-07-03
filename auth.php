<?php
    require "connectDB.php";
    require "testCrud.php";
    require "utils.php";

    init_php_session();
    $db = connect();

    if(isset($_POST["admin"]))
    {
        if($_POST["admin"] == "Inscription")
        {
            //TODO : Verifier les inputs
            // on hash le mot de passe :
            $hmdp = password_hash($_POST['mdp'], PASSWORD_BCRYPT);
            //et on créé l'utilisateur
            $res = Create_User($db, $_POST["nom"], $_POST["prenom"],
            $_POST["identifiant"], $_POST["mail"], $_POST["telephone"], $hmdp, true);
            if($res == "USEDNAME")
            {
                echo "<script>alert(\"Cet identifiant est déjà pris.\")</script>";
            }
            else if($res == "KO")
            {
                echo "<script>alert(\"Un problème est survenu, veuillez réessayer plus tard.\")</script>";
            }
            else
            {
                echo "<script>alert(\"Utilisateur créé avec succès. Vous pouvez maintenant vous connecter.\")</script>";
            }
        }
        else if($_POST["admin"] == "Connexion")
        {
            //TO DO: Verifier les inputs
            var_dump($_POST);

            $res = Get_User($db, $_POST["username"], true);
            if(isset($res))
            {
                var_dump($res);
                var_dump($res["hMdp"]);
                if(password_verify($_POST["mdp"], $res["hMdp"]))
                {
                    init_php_session();

                    $_SESSION['username'] = $_POST['username'];
                    $_SESSION['isAdmin'] = true;
                    header("Location: /index.php");
                }
                else
                {
                    echo "Nom d'utilisateur ou mot de passe invalide.";
                }
            }
            else
                echo "Nom d'utilisateur ou mot de passe invalide.";
        }
                
    }
    else if(isset($_POST["entraineur"]))
    {
        //TODO Verifier les inputs
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css"/>
    <title>Page d'Acceuil</title>
</head>
<body>
    <div class="container">
        <nav id="navbar">
            <a href="./img/tmplogo.png" class="logo">logo</a>
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
                            <form method="POST" id="loginForm">
                                <input type="text" name="username" class="form-control" placeholder="@utilisateur" required>
                                <input type="password" name="mdp" class="form-control" placeholder="@Mot de Passe" required>
                                <input type="submit" name="admin" class="formButton" value="Connexion">
                                
                            </form>

                            <form method="POST" id="registerForm" class="toggleForm">
                                <input type="text" name="nom" class="form-control" placeholder="Nom" required>
                                <input type="text" name="prenom" class="form-control" placeholder="Prénom" required>
                                <input type="text" name="identifiant" class="form-control" placeholder="Identifiant" required>
                                <input type="text" name="mail" class="form-control" placeholder="Adresse mail" required>
                                <input type="text" name="telephone"class="form-control" placeholder="Numéro de téléphone" required>
                                <input type="password" name="mdp" class="form-control" id="mdp" placeholder="@Mot de Passe" required>
                                <input type="password" name="confirmMdp" class="form-control" id="cmdp" placeholder="@Confirmer Mot de Passe" required>
                                <input type="submit" name="admin" class="formButton" id="registerButton" value="Inscription">
                            </form>       
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </div>
        
    <script src="authentification.js"></script>
</body>
</html>
