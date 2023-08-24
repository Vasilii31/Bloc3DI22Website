<!-----------------VERIFIER PHP ICI----------------->
<?php
    require("connectDB.php");
    require("Crud.php");
    require("utils.php");

    $db = connect();

    init_php_session();

    //On verifie la validité de l'idFeuille dans le GET
    if(isset($_GET["feuille"]) && intval($_GET["feuille"]) != 0)
    {
        //on verifie que l'utilisateur est bien authentifié, n'est pas un admin, et 
        //a un identraineur
        if(is_logged() && !is_admin() && isset($_SESSION["IdEntraineur"]) && $_SESSION["IdEntraineur"] != "")
        {
            //on verifie que l'idEntraineur correspond bien a une des deux équipes en question
            if(Verify_TrainerAccess_To_MatchSheet($db, $_GET["feuille"] ,$_SESSION["IdEntraineur"]))
            {
                //Tout est bon, on peut afficher la page et aller chercher les infos
                $myPlayers = Get_Players_From_Trainer($db, $_SESSION["IdEntraineur"]);
            }
            else
            {
                //cet entraineur ne devrait pas avoir accès a cette feuille de match,
                //On redirige avec DisplayAndRedirect
            }
        }
    }
    else
    {
        //Une erreur est survenue, redirection avec DisplayAndRedirect
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
    <title>Feuille de Match - Entraineur</title>
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
        <h1>Titre Page</h1>


<!-----------------SECTION 1----------------->       
            <div class="football_player_content_section">
                <h2>Titre Section 1</h2>

<!-----------------SOUS SECTION 1.1-----------------> 
                <div class="football_player_content_subsection">
                    <p>Paragraphe</p>
                </div>

            </div>

<!-----------------SECTION 2-----------------> 
            <div class="football_player_content_section">
                <h2>Titre Section 2</h2>

<!-----------------SOUS SECTION 2.1-----------------> 
                <div class="football_player_content_subsection">
                    <p>Paragraphe</p>
                </div>

<!-----------------SOUS SECTION 2.2----------------->                  
                <div class="football_player_content_subsection">
                    <p>Paragraphe</p>
                </div>

            </div>
        
        
<!-----------------SECTION 3----------------->
            <div class="football_player_content_section">
                <h2>Titre Section 3</h2>

<!-----------------SOUS SECTION 3.1-----------------> 
                <div class="football_player_content_subsection">
                    <p>Paragraphe</p>
                </div>

<!-----------------SOUS SECTION 3.2----------------->            
                <div class="football_player_content_subsection">
                    <p>Paragraphe</p>
                </div>                
                    
                <div class="football_player_content_subsection">
                    <p>Paragraphe</p>
                </div>
                    
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
    <script src="acceuilPreConnexion.js"></script>
</body>

<footer>
    <?php
        include("footer.html")
    ?>
</footer>

</html>