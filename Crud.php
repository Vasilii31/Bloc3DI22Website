<?php

    function Get_Clubs($db)
    {
        $sReq = "SELECT * FROM clubs";
        $res = $db->query($sReq)->fetchAll();
        return $res;
    }

    function Get_Referees($db)
    {
        $sReq = "SELECT * FROM arbitres";
        $res = $db->query($sReq)->fetchAll();
        return $res;
    }

    // function Add_New_Match_Sheet($db, $date, $lieu, $equi1, $equi2, $arbitreP, $arbitreAss1, $arbitreAss2)
    // {
    //     $sReq = "INSERT INTO feuilledematch (DateRencontre, Lieu, IdEquipe1, IdEquipe2, IdArbitrePrinc, IdArbitreAss1, IdArbitreAss2) VALUES (?, ?, ?, ?, ?, ?, ?)";
    //     $dbh = $db->prepare($sReq);
    //     $dbh->execute([
    //         $date,
    //         $lieu,
    //         $equi1,
    //         $equi2,
    //         $arbitreP,
    //         $arbitreAss1,
    //         $arbitreAss2
    //     ]);
    // }

    //Doublon, a tester
    function Add_New_Match_Sheet($db)
    {
        $DateRencontre = $_POST['DateRencontre'];
        $Stade = $_POST['Stade'];
        $Equipe1 = $_POST['Equipe1'];
        $Equipe2 = $_POST['Equipe2'];
        $ArbitrePrinc = $_POST['ArbitrePrinc'];
        $ArbitreAss1 = $_POST['ArbitreAss1'];
        $ArbitreAss2 = $_POST['ArbitreAss2'];
    
        $req = "INSERT INTO feuilledematch (DateRencontre, Stade, IdEquipe1, IdEquipe2, IdArbitrePrinc, IdArbitreAss1, IdArbitreAss2) VALUES (:DateRencontre, :Stade, :Equipe1, :Equipe2, :ArbitrePrinc, :ArbitreAss1, :ArbitreAss2)";
    
        $insertFeuilleDeMatch = $db -> prepare($req);
        $insertFeuilleDeMatch -> execute(array(
            ':DateRencontre' => $DateRencontre,
            ':Stade' => $Stade,
            ':Equipe1' => $Equipe1,
            ':Equipe2' => $Equipe2,
            'ArbitrePrinc' => $ArbitrePrinc,
            ':ArbitreAss1' => $ArbitreAss1,
            ':ArbitreAss2' => $ArbitreAss2
        ));
    }

function Get_Pending_Matchs($db)
{
    $sReq = "SELECT c1.NomClub as NomEquipe1, c2.NomClub as NomEquipe2, DateRencontre, Lieu FROM feuilledematch AS f INNER JOIN clubs AS c1 ON f.IdEquipe1 = c1.IdClub INNER JOIN clubs as c2 on f.IdEquipe2 = c2.IdClub INNER JOIN arbitres as a1 on f.IdArbitrePrinc = a1.IdArbitre INNER JOIN arbitres as a2 on f.IdArbitreAss1 = a2.IdArbitre INNER JOIN arbitres as a3 on f.IdArbitreAss2 = a3.IdArbitre";
    $res = $db->query($sReq)->fetchAll();
    return $res;

}

function Create_User($db, $nom, $prenom, $id, $mail, $tel, $hmdp, $isAdmin)
{
    //on cherche avant tout dans la table users si le username n'est pas deja pris
    $sReq = $db->prepare("SELECT userName FROM users WHERE userName = ?");
    $sReq->execute([$id]);
    $res = $sReq->fetch();
    //si on a pas de résultat, le username n'est pas pris
    //on peut créer l'utilisateur
    if($res == false)
    {
        $sReq = "INSERT INTO users (userName, hmdp, isAdmin, mail, nom, prenom, numtel) VALUES (?, ?, ?, ?, ?, ?, ?)";
            $dbh = $db->prepare($sReq);
            if($dbh->execute([
                $id,
                $hmdp,
                $isAdmin,
                $mail,
                $nom,
                $prenom,
                $tel
            ]) == false)
            {
                //l'insert n'a pas marché, on traite l'erreur
                return "KO";
            }
            else//on renvoie un code succes
                return "OK";
    }
    else
    {
        //ce nom d'utilisateur est déja pris, on renvoie un code d'erreur
        //pour avertir l'utilisateur
        return "USEDNAME";
    }
}

function Get_User($db, $username, $isAdmin)
{
    $sUsername = filter_var($username, FILTER_SANITIZE_STRING);
    if($sUsername == false)
    {
        return null;
    }
    else
    {
        $dbh = $db->prepare("SELECT userName, hMdp FROM users WHERE userName = ? AND isAdmin = ?");
        $dbh->execute([$username, $isAdmin]);
    }
    return $dbh->fetch();
}

function VerifyAdminCreation($db, $codeAdmin)
{
    //va chercher le code admin en base de données et compare avec l'input
    //retourne true si le code est bon
    //false si code KO
    $codeAdmin = intval($codeAdmin);
    if($codeAdmin > 0)
    {
        $dbh = $db->prepare("SELECT CodeAdmin FROM codeadmin");
        $dbh->execute();
        $res = $dbh->fetch();
        return(password_verify($codeAdmin, $res["CodeAdmin"]));
    }
    return(false);
}

function Get_Match_infos($db, $idFeuille)
{
    $idFeuille = intval($idFeuille);
    if($idFeuille > 0)
    {
        $dbh = $db->prepare("SELECT DateRencontre, Lieu, c1.NomClub as Equipe1, c2.NomClub as Equipe2  FROM feuilledematch AS f INNER JOIN clubs AS c1 ON f.IdEquipe1 = c1.IdClub INNER JOIN clubs as c2 on f.IdEquipe2 = c2.IdClub WHERE IdFeuille = ?");
        $dbh->execute([$idFeuille]);
    }
    return $dbh->fetch();
}

function Get_All_Positions($db)
{
    $sReq = "SELECT * FROM postes";
    $res = $db->query($sReq)->fetchAll();
    return $res;
}

function Get_team($db, $idequipe)
{
    if(is_int($idequipe))
    {
        $dbh = $db->prepare("SELECT IdEquipe, NomEquipe FROM equipes WHERE IdEquipe = ?");
        $dbh->execute([$idequipe]);
        $res = $dbh->fetch();
    }
    return $res;
}