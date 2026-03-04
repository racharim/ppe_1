<?php

require_once __DIR__ . '/../../config/database.php';

class participeModele {
    private int $id_joueur;
    private int $id_match;

    function getAllByJoueurID(int $id_joueur){
        $reqSQL="SELECT * FROM participe WHERE id_joueur = :id_joueur ;";
        $requete = dataBase::get()->prepare($reqSQL);
        $requete->BindValue(':id_joueur',$id_joueur,PDO::PARAM_INT);
        $requete->execute();
        $matchs = $requete->fetchall(PDO::FETCH_ASSOC);
        return $matchs;
    }

    function addParticipation(int $id_joueur, int $id_match){
        $reqSQL="INSERT INTO participe (id_joueur, id_match) VALUES (:id_joueur, :id_match);";
        $requete = dataBase::get()->prepare($reqSQL);
        $requete->BindValue(':id_joueur', $id_joueur, PDO::PARAM_INT);
        $requete->BindValue(':id_match', $id_match, PDO::PARAM_INT);
        return $requete->execute();
    }

    function removeParticipation(int $id_joueur, int $id_match){
        $reqSQL="DELETE FROM participe WHERE id_joueur = :id_joueur AND id_match = :id_match;";
        $requete = dataBase::get()->prepare($reqSQL);
        $requete->BindValue(':id_joueur', $id_joueur, PDO::PARAM_INT);
        $requete->BindValue(':id_match', $id_match, PDO::PARAM_INT);
        return $requete->execute();
    }

    function isParticipating(int $id_joueur, int $id_match){
        $reqSQL="SELECT * FROM participe WHERE id_joueur = :id_joueur AND id_match = :id_match;";
        $requete = dataBase::get()->prepare($reqSQL);
        $requete->BindValue(':id_joueur', $id_joueur, PDO::PARAM_INT);
        $requete->BindValue(':id_match', $id_match, PDO::PARAM_INT);
        $requete->execute();
        return $requete->fetch(PDO::FETCH_ASSOC) !== false;
    }
}