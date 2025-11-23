<?php
require_once '../config/database.php';

class matchModele{
    function getMatchByDate(string $date){
        $reqSQL="SELECT * FROM match_ WHERE date = :date ;";
        $requete = dataBase::get()->prepare($reqSQL);
        $requete->BindValue(':date',$date,PDO::PARAM_STR);
        $requete->execute();
        $match = $requete->fetchall(PDO::FETCH_ASSOC);
        return $matchsForDate;
    }

    function getAllNextMatchs(string $currentDate){
        $reqSQL="SELECT * FROM match_ WHERE date > :date ;";
        $requete = dataBase::get()->prepare($reqSQL);
        $requete->execute();
        $matchs = $requete->fetchAll(PDO::FETCH_ASSOC);
        return $nextMatchs;
    }

    function getMatchId(int $idMatch){
        $reqSQL="SELECT * FROM match_ WHERE id_match = :idMatch ;";
        $requete = dataBase::get()->prepare($reqSQL);
        $requete->BindValue(':idMatch',$idMatch,PDO::PARAM_INT);
        $requete->execute();
        $match = $requete->fetch(PDO::FETCH_ASSOC); 
    }
}