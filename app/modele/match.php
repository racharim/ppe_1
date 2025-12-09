<?php
require_once '../../config/database.php';

class matchModele{
    function getMatchByDate(string $date){
        $reqSQL="SELECT * FROM match_ WHERE date = :date ;";
        $requete = dataBase::get()->prepare($reqSQL);
        $requete->BindValue(':date',$date,PDO::PARAM_STR);
        $requete->execute();
        $match = $requete->fetchall(PDO::FETCH_ASSOC);
        return $match;
    }

    function getAllNextMatchs(string $currentDate){
        $reqSQL="SELECT * FROM match_ WHERE date > :date ;";
        $requete = dataBase::get()->prepare($reqSQL);
        $requete->execute();
        $matchs = $requete->fetchAll(PDO::FETCH_ASSOC);
        return $matchs;
    }

    function getMatchId(int $idMatch){
        $reqSQL="SELECT * FROM match_ WHERE id_match = :idMatch ;";
        $requete = dataBase::get()->prepare($reqSQL);
        $requete->BindValue(':idMatch',$idMatch,PDO::PARAM_INT);
        $requete->execute();
        $match = $requete->fetch(PDO::FETCH_ASSOC); 
        return $match;
    }

    function getMatchByFav($idJoueur){
        $reqSQL="SELECT m.libéllé AS nom_match,m.date_debut,m.descriptif FROM match_ m JOIN favoris f ON m.id_sport = f.id_sport JOIN sport s ON m.id_sport = s.id_sport WHERE  f.id_joueur = :idJoueur;";
        $requete = dataBase::get()->prepare($reqSQL);
        $requete->BindValue(':idJoueur',$idJoueur,PDO::PARAM_INT);
        $requete->execute();
        $match = $requete->fetch(PDO::FETCH_ASSOC); 
        return $match;
    }
}