<?php

require_once '../../config/database.php';

class favorisModele {

    function getfavorisById(int $id){
        $reqSQL="SELECT * FROM favoris WHERE id_joueur  = :id ;";
        $requete = dataBase::get()->prepare($reqSQL);
        $requete->BindValue(':id',$id,PDO::PARAM_INT);
        $requete->execute();
        $favoris = $requete->fetchall(PDO::FETCH_ASSOC);
        return $favoris;
    }

    function addFavoris(int $idJoueur, int $idSport){
        $reqSQL = "INSERT INTO favoris (id_joueur, id_sport) VALUES (:idJoueur, :idSport)";
        $requete = dataBase::get()->prepare($reqSQL);
        $requete->BindValue(':idJoueur', $idJoueur, PDO::PARAM_INT);
        $requete->BindValue(':idSport', $idSport, PDO::PARAM_INT);
        return $requete->execute();
    }
}