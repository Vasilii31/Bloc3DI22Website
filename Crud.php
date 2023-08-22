<?php

    function Get_Clubs($db)
    {
        $sReq = "SELECT * FROM clubs";
        $res = $db->query($sReq)->fetchAll();
        return $res;
    };

    function Get_Referees($db)
    {
        $sReq = "SELECT * FROM arbitres";
        $res = $db->query($sReq)->fetchAll();
        return $res;
    };

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
    function Add_New_Match_Sheet($db, $DateRencontre, $Stade, $Equipe1, $Equipe2, $ArbitrePrinc, $ArbitreAss1, $ArbitreAss2)
    {
    
        $req = "INSERT INTO feuilledematch (DateRencontre, Lieu, IdEquipe1, IdEquipe2, IdArbitrePrinc, IdArbitreAss1, IdArbitreAss2) VALUES (:DateRencontre, :Stade, :Equipe1, :Equipe2, :ArbitrePrinc, :ArbitreAss1, :ArbitreAss2)";
    
        $insertFeuilleDeMatch = $db -> prepare($req);
        if($insertFeuilleDeMatch -> execute(array(
            ':DateRencontre' => $DateRencontre,
            ':Stade' => $Stade,
            ':Equipe1' => $Equipe1,
            ':Equipe2' => $Equipe2,
            ':ArbitrePrinc' => $ArbitrePrinc,
            ':ArbitreAss1' => $ArbitreAss1,
            ':ArbitreAss2' => $ArbitreAss2
        )) == false)
        {
            $id = -1;
        }
        else
        {
            $id = $db->lastInsertId();
        } 
        return($id);
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
    $approuved = $isAdmin ? true : false;
    $sReq = $db->prepare("SELECT userName FROM users WHERE userName = ?");
    $sReq->execute([$id]);
    $res = $sReq->fetch();
    //si on a pas de résultat, le username n'est pas pris
    //on peut créer l'utilisateur
    if($res == false)
    {
        $sReq = "INSERT INTO users (userName, hmdp, isAdmin, approuved, mail, nom, prenom, numtel) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
            $dbh = $db->prepare($sReq);
            if($dbh->execute([
                $id,
                $hmdp,
                $isAdmin,
                $approuved,
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

function Get_All_Postes($db)
{
    $sReq = "SELECT * FROM postes";
    $res = $db->query($sReq)->fetchAll();
    return $res;
}

//recupère la team liée à l'idEquipe dans la bdd: table equipes
function Get_team($db, $idequipe)
{
    $newId = intval($idequipe);
    if(is_int($newId) && $newId > 0)
    {
        $dbh = $db->prepare("SELECT IdEquipe, NomEquipe FROM equipes WHERE IdEquipe = ?");
        $dbh->execute([$newId]);
        $res = $dbh->fetch();
    }
    return $res;
}

//Ajoute un joueur dans la BDD:  table joueurs
function Create_Player($db, $nom, $prenom, $numMaillot, $idPoste, $equipe)
{
    $sReq = "INSERT INTO joueurs (Nom, Prenom, NumeroMaillot, IdEquipe, IdPostePredilection) VALUES (?, ?, ?, ?, ?)";
    $dbh = $db->prepare($sReq);
    if($dbh->execute([
        $nom,
        $prenom,
        $numMaillot,
        $equipe,
        $idPoste
    ]) == false)
    {
        //l'insert n'a pas marché, on traite l'erreur
        return "KO";
    }
    else
        return "OK"; 
}

function Create_All_Sheets($db, $idFeuille, $idEquipe1, $idEquipe2)
{
    $res = "MATCHCREATED";
    $sReq = "INSERT INTO feuillematchentraineur (Idfeuilledematch, IdEquipe) VALUES (?, ?)";
    $dbh = $db->prepare($sReq);
    if($dbh->execute([
        $idFeuille,
        $idEquipe1
    ]) == false)
    {
        //l'insert n'a pas marché, on traite l'erreur
        $res = "KO";
    }
    $sReq = "INSERT INTO feuillematchentraineur (Idfeuilledematch, IdEquipe) VALUES (?, ?)";
    $dbh = $db->prepare($sReq);
    if($dbh->execute([
        $idFeuille,
        $idEquipe2
    ]) == false)
    {
        //l'insert n'a pas marché, on traite l'erreur
        $res = "KO";
    }
    return $res;
}

function Get_pending_trainers($db)
{

    $dbh = $db->prepare("SELECT * FROM users WHERE isAdmin = false AND approuved = false");
    $dbh->execute();
    return $dbh->fetchAll();
}

function Get_All_Players_from_team($db, $idequipe)
{
    $dbh = $db->prepare("SELECT * FROM joueurs WHERE IdEquipe = ?");
    $dbh->execute([$idequipe]);
    $res = $dbh->fetchAll();

    return $res;
}
// function Get_Trainer_Team($db, $username)
// {
//     if($username != null && $username != "")
//     {
//         $dbh = $db->prepare("SELECT t.IdEquipe FROM users WHERE $username = ? AND ");
//         $dbh->execute([$newId]);
//         $res = $dbh->fetch();
//     }
//     return $res;
// }