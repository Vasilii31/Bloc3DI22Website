<?php
    require("connectDB.php");
    require("testCrud.php");
    $db = connect();
    
    $clubs = GetClubs($db);
    $arbitres = GetArbitres($db);
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
        <form action="CreateFeuilleMatch.php" method="POST">

        <input type="date" name="DateRencontre" onchange="dateHandler(value);" id="inputDate" required>
        <div id="equipe1" class="hidden">
            <select id="equip1selector" name="equipe1" onchange="equip1Handler(value);" required><option value="">Equipe N°1</option>
                <?php 
                    if(isset($clubs))
                    {
                        $index = 1;
                        foreach($clubs as $club)
                        {
                            echo "<option id='equip1opt".$index."' value=".$club['IdClub'].">".$club['NomClub']."</option>";
                            $index++;
                        }
                    }
                ?>
            </select>
        </div>
        <div id="equipe2" class="hidden">
            
            <select id="equip2selector" name="equipe2" onchange="equip2Handler(value);" required><option value="">Equipe N°2</option>
            <?php 
                    if(isset($clubs))
                    {
                        $index = 1;
                        foreach($clubs as $club)
                        {                           
                            echo "<option id='equip2opt".$index."' value=".$club['IdClub'].">".$club['NomClub']."</option>";
                            $index++;
                        }
                    }
                ?>
            </select>
        </div>
        <div id="lieux">
            <input type="text" name="lieu" placeholder="lieux de rencontre" id="">
        </div>
        <div id="arbitres">
            <div id="arbitrePrinc">
            <select id="arbitrePrincSelector" name="ArbitreP" onchange="" required><option value="">Arbitre Principal</option>
            <?php 
                    if(isset($arbitres))
                    {
                        $index = 1;
                        foreach($arbitres as $arbitre)
                        {                           
                            echo "<option id='arbitrePrincSelector".$index."' value=".$arbitre['IdArbitre'].">".$arbitre['NomArbitre']."</option>";
                            $index++;
                        }
                    }
                ?>
            </select>
            </div>
            <div id="arbitreAss">
            <select id="arbitreAssSelector1" name="ArbitreA1" onchange="" required><option value="">Arbitre Assistant 1</option>
            <?php 
                    if(isset($arbitres))
                    {
                        $index = 1;
                        foreach($arbitres as $arbitre)
                        {                           
                            echo "<option id='arbitrePrincSelector".$index."' value=".$arbitre['IdArbitre'].">".$arbitre['NomArbitre']."</option>";
                            $index++;
                        }
                    }
                ?>
            </select>
            <select id="arbitreAssSelector2" name="ArbitreA2" onchange="" required><option value="">Arbitre Assistant 2</option>
            <?php 
                    if(isset($arbitres))
                    {
                        $index = 1;
                        foreach($arbitres as $arbitre)
                        {                           
                            echo "<option id='arbitrePrincSelector".$index."' value=".$arbitre['IdArbitre'].">".$arbitre['NomArbitre']."</option>";
                            $index++;
                        }
                    }
                ?>
            </select>
            <input type="checkbox" id="scales" name="scales" unchecked>
            <label for="scales">Envoyer un mail aux entraineurs concernés</label>
            <a href = "mailto: abc@example.com">Send Email</a>
            </div>
        </div>            
        <input type="submit" value="Valider la feuille de Match">
        </form>
    </div>
    <script src="acceuilPreConnexion.js"></script>
</body>
</html>