<?php

require_once '../../config/database.php';

class SportModele {
    
    function getAllSports(){
        $reqSQL="SELECT * FROM sport ;";
        $requete = dataBase::get()->prepare($reqSQL);
        $requete->execute();
        $sports = $requete->fetchAll(PDO::FETCH_ASSOC);
        return $sports;
    }

    function getSportByName(string $name){
        $reqSQL="SELECT * FROM sport WHERE nom = :name ;";
        $requete = dataBase::get()->prepare($reqSQL);
        $requete->BindValue(':name',$name,PDO::PARAM_STR);
        $requete->execute();
        $sport = $requete->fetchall(PDO::FETCH_ASSOC);
        return $sport;
    } 
}