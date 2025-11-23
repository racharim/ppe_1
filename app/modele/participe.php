<?php

class participeModele {
    private int $id_joueur;
    private int $id_match;

    function getAllMatchByJoueur(int $id_joueur){
        $reqSQL="SELECT * FROM participe WHERE id_joueur = :id_joueur ;";
        $requete = dataBase::get()->prepare($reqSQL);
        $requete->BindValue(':id_joueur',$id_joueur,PDO::PARAM_INT);
        $requete->execute();
        $matchs = $requete->fetchall(PDO::FETCH_ASSOC);
        return $matchs;
    }
}