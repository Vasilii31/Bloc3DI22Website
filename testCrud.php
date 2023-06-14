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