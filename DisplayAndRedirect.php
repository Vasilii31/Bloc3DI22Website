<?php
    if(isset($_GET))
    {
        var_dump($_GET);

        switch($_GET["result"])
        {
            case "OK":
                $output = "Utilisateur créé avec succès, vous pouvez maintenant vous connecter.";
                $href = "auth.php";
                break;
            case "USEDNAME":
                $output = "Ce nom d'utilisateur est déjà pris.";
                $href = "auth.php";
                break;
            case "INVALIDADMINCODE":
                $output = "Le code de création administrateur est incorrect.";
                $href = "auth.php";
                break;
            case "KOIDPWD":
                $output = "Identifiant ou mot de passe incorrect";
                $href = "auth.php";
                break;
            case "TEAMNOTFOUND":
                $output = "Erreur : équipe introuvable.";
                $href = "index.php";
                break;
            case "MATCHCREATED":
                $output = "Le match a été créé avec succès.";
                $href = "index.php";
                break;
            default:
                $output = "Une erreur est survenue. Veuillez réessayer plus tard.";
                $href = "index.php";
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
    <a href=<?php echo $href;?>>Retour</a>
</body>
</html>