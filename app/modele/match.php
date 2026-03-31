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

    function getMatchsBySport(int $idSport){
        $reqSQL="SELECT id_match, libéllé AS nom_match, date_debut, date_fin, descriptif 
                 FROM match_ 
                 WHERE id_sport = :id_sport 
                 ORDER BY date_debut ASC;";
        $requete = dataBase::get()->prepare($reqSQL);
        $requete->BindValue(':id_sport',$idSport,PDO::PARAM_INT);
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

    function getMatchesParMois() {
        $reqSQL = "SELECT DATE_FORMAT(date_debut, '%Y-%m') AS mois, COUNT(id_match) AS nb_matchs
                   FROM match_
                   GROUP BY mois
                   ORDER BY mois ASC;";
        $requete = dataBase::get()->prepare($reqSQL);
        $requete->execute();
        return $requete->fetchAll(PDO::FETCH_ASSOC);
    }

    function getMatchDetails(int $id_match) {
        $reqSQL = "SELECT m.*, s.nom as nom_sport, l.n_rue, l.rue, l.code_postal, n.libéllé as niveau
                   FROM match_ m
                   JOIN sport s ON m.id_sport = s.id_sport
                   JOIN lieu l ON m.id_lieu = l.id_lieu
                   JOIN niveau n ON m.id_niv = n.id_niv
                   WHERE m.id_match = :id_match;";
        $requete = dataBase::get()->prepare($reqSQL);
        $requete->BindValue(':id_match', $id_match, PDO::PARAM_INT);
        $requete->execute();
        return $requete->fetch(PDO::FETCH_ASSOC);
    }

    function updateMatch(int $id_match, string $libelle, string $descriptif, string $date_debut, string $date_fin) {
        $reqSQL = "UPDATE match_ 
                   SET libéllé = :libelle, descriptif = :descriptif, date_debut = :date_debut, date_fin = :date_fin
                   WHERE id_match = :id_match;";
        $requete = dataBase::get()->prepare($reqSQL);
        $requete->bindValue(':libelle', $libelle, PDO::PARAM_STR);
        $requete->bindValue(':descriptif', $descriptif, PDO::PARAM_STR);
        $requete->bindValue(':date_debut', $date_debut, PDO::PARAM_STR);
        $requete->bindValue(':date_fin', $date_fin, PDO::PARAM_STR);
        $requete->bindValue(':id_match', $id_match, PDO::PARAM_INT);
        return $requete->execute();
    }
}