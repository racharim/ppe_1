<?php
require_once '../config/database.php';

class coachModele {

    function getcoachByUId(int $id){
        $reqSQL="SELECT * FROM coach WHERE id_utilisateur  = :id ;";
        $requete = dataBase::get()->prepare($reqSQL);
        $requete->BindValue(':id',$id,PDO::PARAM_INT);
        $requete->execute();
        $coach = $requete->fetch(PDO::FETCH_ASSOC);
        return $coach;
    }
}