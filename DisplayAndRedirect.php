<?php
    if(isset($_GET))
    {
        var_dump($_GET);

        switch($_GET["result"])
        {
            case "OK":
                $output = "Utilisateur créé avec succès, vous pouvez maintenant vous connecter.";
                break;
            case "USEDNAME":
                $output = "Ce nom d'utilisateur est déjà pris.";
                break;
            case "INVALIDADMINCODE":
                $output = "Le code de création administrateur est incorrect.";
                break;
            case "KOIDPWD":
                $output = "Identifiant ou mot de passe incorrect";
                break;
            default:
                $output = "Une erreur est survenue. Veuillez réessayer plus tard.";
                break;                
        }
    }
    

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1><?php echo $output;?></h1>
    <a href="auth.php">Retourner à l'écran de connexion</a>
</body>
</html>