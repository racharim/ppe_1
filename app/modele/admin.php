<?php
require_once '../config/database.php';

class adminModele {

    function getadminByUId(int $id){
        $reqSQL="SELECT * FROM admin WHERE id_utilisateur  = :id ;";
        $requete = dataBase::get()->prepare($reqSQL);
        $requete->BindValue(':id',$id,PDO::PARAM_INT);
        $requete->execute();
        $admin = $requete->fetch(PDO::FETCH_ASSOC);
        return $admin;
    }
}