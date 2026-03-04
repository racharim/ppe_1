<?php
require_once __DIR__ . '/../../config/database.php';

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
        $reqSQL="SELECT * FROM match_ WHERE date_debut >= :date ;";
        $requete = dataBase::get()->prepare($reqSQL);
        $requete->BindValue(':date',$currentDate,PDO::PARAM_STR);
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
        $reqSQL="SELECT m.id_match, m.libéllé AS nom_match, m.date_debut, m.descriptif 
                 FROM match_ m 
                 JOIN favoris f ON m.id_sport = f.id_sport 
                 JOIN sport s ON m.id_sport = s.id_sport 
                 WHERE f.id_joueur = :idJoueur 
                 AND m.id_match NOT IN (SELECT id_match FROM participe WHERE id_joueur = :idJoueur);";
        $requete = dataBase::get()->prepare($reqSQL);
        $requete->BindValue(':idJoueur',$idJoueur,PDO::PARAM_INT);
        $requete->execute();
        $matchs = $requete->fetchAll(PDO::FETCH_ASSOC); 
        return $matchs;
    }
            
    function addMatch($libelle, $descriptif, $date_debut, $date_fin, $id_niv, $id_sport, $id_lieu) {
        $reqSQL = "INSERT INTO match_ (libéllé, descriptif, date_debut, date_fin, id_niv, id_sport, id_lieu) 
                VALUES (:libelle, :descriptif, :date_debut, :date_fin, :id_niv, :id_sport, :id_lieu);";
        $requete = dataBase::get()->prepare($reqSQL);
        $requete->bindValue(':libelle', $libelle, PDO::PARAM_STR);
        $requete->bindValue(':descriptif', $descriptif, PDO::PARAM_STR);
        $requete->bindValue(':date_debut', $date_debut, PDO::PARAM_STR);
        $requete->bindValue(':date_fin', $date_fin, PDO::PARAM_STR);
        $requete->bindValue(':id_niv', $id_niv, PDO::PARAM_INT);
        $requete->bindValue(':id_sport', $id_sport, PDO::PARAM_INT);
        $requete->bindValue(':id_lieu', $id_lieu, PDO::PARAM_INT);
        return $requete->execute();
    }
}