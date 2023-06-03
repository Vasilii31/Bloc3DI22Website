<?php
    require("connectDB.php");
    require("testCrud.php");
    $db = connect();
    
    $clubs = GetClubs($db);

    /*if(!isset($db))
    {
        var_dump($db);
        echo "la connexion a la base de données a échoué";
    }*/

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style2.css"/>
    <title>Feuille de Match</title>
</head>
<body>
    <h1>Création de Feuille de Match</h1>
    <?php
    if($db == NULL)
    {
        //var_dump($db);
        echo "la connexion a la base de données a échoué";
    }
    else{
        echo "bravo connexion effectuée";
    }  ?>

    <div class="rencontre">
        <form action="" method="GET">

        <input type="date" name="DateRencontre" onchange="dateHandler(value);" id="inputDate" required>
        <div id="equipe1" class="hidden">
            <select name="equipe1" onchange="equip1Handler(value);"><option value="">Equipe N°1</option>
                <?php 
                    if(isset($clubs))
                    {
                        foreach($clubs as $club)
                        {
                            echo "<option value=".$club['IdClub'].">".$club['NomClub']."</option>";
                        }
                    }
                ?>
            </select>
        </div>
        <div id="equipe2" class="hidden">
            
            <select name="equipe2" onchange="equip2Handler(value);" id=""><option value="">Equipe N°2</option></select>
        </div>
            <select name="Lieu" required></select>

        <select name="Stade">
        <input type="submit" value="Valider la feuille de Match">
        </form>
    </div>
    <script src="acceuilPreConnexion.js"></script>
</body>
</html>