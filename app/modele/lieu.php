<?php

require_once __DIR__ .'/../../config/database.php';

class lieuModele {

    function getAllLieux(){
        $reqSQL = "SELECT * FROM lieu ;";
        $requete = dataBase::get()->prepare($reqSQL);
        $requete->execute();
        $lieux = $requete->fetchAll(PDO::FETCH_ASSOC);
        return $lieux;
    }

    function getLieuById(int $id){
        $reqSQL = "SELECT * FROM lieu WHERE id_lieu = :id ;";
        $requete = dataBase::get()->prepare($reqSQL);
        $requete->BindValue(':id', $id, PDO::PARAM_INT);
        $requete->execute();
        $lieu = $requete->fetch(PDO::FETCH_ASSOC);
        return $lieu;
    }

    function addLieu(string $rue, int $n_rue, int $code_postal) {
        $reqSQL = "INSERT INTO lieu (rue, n_rue, code_postal) VALUES (:rue, :n_rue, :code_postal);";
        $requete = dataBase::get()->prepare($reqSQL);
        $requete->bindValue(':rue', $rue, PDO::PARAM_STR);
        $requete->bindValue(':n_rue', $n_rue, PDO::PARAM_INT);
        $requete->bindValue(':code_postal', $code_postal, PDO::PARAM_INT);
        return $requete->execute();
    }
}
?>
