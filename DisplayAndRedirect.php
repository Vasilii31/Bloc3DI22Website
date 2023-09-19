<?php
    if(isset($_GET))
    {
        var_dump($_GET);

        switch($_GET["result"])
        {
            case "CREATEADMINOK":
                $output = "Utilisateur Administrateur créé avec succès, vous pouvez maintenant vous connecter.";
                $href = "index.php";
                break;
            case "CREATETRAINEROK":
                $output = "Votre demande de création d'un profil entraineur a été prise en compte et va être examinée par un Administrateur. Vous pourrez vous connecter lorsqu'elle aura été approuvée.";
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
            case "KONOTAPPROVED":
                $output = "Votre création de profil a été refusé par l'administrateur.";
                $href = "auth.php";
                break;
            case "KOAWAITAPPROVAL":
                $output = "La validation de votre profil par l'administrateur est encore en attente, veuillez réessayer plus tard.";
                $href = "auth.php";
                break;
            case "KODENIEDACCESS":
                $output = "Désolé, vous n'avez pas accès à cette page";
                $href = "index.php";
                break;
            case "MATCHCOMPLETE":
                $output = "La feuille de résultat du match a été complétée avec succès. Vous pouvez la retrouver dans l'écran Historique des Matchs.";
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