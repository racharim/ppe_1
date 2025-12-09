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
}