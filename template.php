
<!-----------------VERIFIER PHP ICI----------------->
<?php
    require("connectDB.php");
    require("Crud.php");
    $db = connect();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/style2.css"/>
    <link rel="stylesheet" href="./css/templateStyle.css"/>
<!-----------------TITLE A COMPLETER----------------->
    <title>A COMPLETER</title>
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