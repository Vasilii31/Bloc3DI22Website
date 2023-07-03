<?php
    
    function GetClubs($db)
    {
        $sReq = "SELECT * FROM clubs";
        $res = $db->query($sReq)->fetchAll();
        return $res;
    }

    function GetArbitres($db)
    {
        $sReq = "SELECT * FROM arbitres";
        $res = $db->query($sReq)->fetchAll();
        return $res;
    }

    function AddFeuilleMatch($db, $date, $lieu, $equi1, $equi2, $arbitreP, $arbitreAss1, $arbitreAss2)
    {
        $sReq = "INSERT INTO feuilledematch (DateRencontre, Lieu, IdEquipe1, IdEquipe2, IdArbitrePrinc, IdArbitreAss1, IdArbitreAss2) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $dbh = $db->prepare($sReq);
        $dbh->execute([
            $date,
            $lieu,
            $equi1,
            $equi2,
            $arbitreP,
            $arbitreAss1,
            $arbitreAss2
        ]);
    }

function GetMatchs_NonCompletes($db)
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
    $dbh = $db->prepare("SELECT userName, hMdp FROM users WHERE userName = ? AND isAdmin = ?");
        $dbh->execute([$username, $isAdmin]);
        return $dbh->fetch();
}