<?php
    
    function GetClubs($db)
    {
        $sReq = "select * FROM Clubs";
        $res = $db->query($sReq)->fetchAll();
        return $res;
    }