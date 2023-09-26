<?php
    require("utils.php");
    
    init_php_session();
    
    if(!is_logged())
        header("location: /auth.php");
    if(isset($_GET["admin"]))
    {
        if($_GET["admin"] == false)
        {
            $profils = "Administrateurs";
        }
        else
        {
            $profils = "Entraineurs";
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
    <h2>Désolé, cette page est réservée aux profils <?php echo $profils;?>.</h2>
    <a href="index.php">Retourner sur ma page</a>
</body>
</html>