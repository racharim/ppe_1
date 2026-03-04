<?php

require_once __DIR__ .'/../../config/database.php';

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

    function getSportById(int $id){
        $reqSQL="SELECT * FROM sport WHERE id_sport = :id ;";
        $requete = dataBase::get()->prepare($reqSQL);
        $requete->BindValue(':id',$id,PDO::PARAM_INT);
        $requete->execute();
        $sport = $requete->fetch(PDO::FETCH_ASSOC);
        return $sport;
    }

    function addSport(string $nom, int $n_joueur, string $descriptif) {
    $reqSQL = "INSERT INTO sport (nom, n_joueur, descriptif) VALUES (:nom, :n_joueur, :descriptif);";
    $requete = dataBase::get()->prepare($reqSQL);
    $requete->bindValue(':nom', $nom, PDO::PARAM_STR);
    $requete->bindValue(':n_joueur', $n_joueur, PDO::PARAM_INT);
    $requete->bindValue(':descriptif', $descriptif, PDO::PARAM_STR);
    return $requete->execute();
    }
}