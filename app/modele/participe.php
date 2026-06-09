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

    function getParticipantCountByMatchId(int $id_match): int {
        $reqSQL = "SELECT COUNT(*) AS total FROM participe WHERE id_match = :id_match;";
        $requete = dataBase::get()->prepare($reqSQL);
        $requete->BindValue(':id_match', $id_match, PDO::PARAM_INT);
        $requete->execute();
        $result = $requete->fetch(PDO::FETCH_ASSOC);
        return (int)($result['total'] ?? 0);
    }

    function getMatchCapacity(int $id_match): int {
        $reqSQL = "SELECT s.n_joueur
                   FROM match_ m
                   JOIN sport s ON m.id_sport = s.id_sport
                   WHERE m.id_match = :id_match;";
        $requete = dataBase::get()->prepare($reqSQL);
        $requete->BindValue(':id_match', $id_match, PDO::PARAM_INT);
        $requete->execute();
        $result = $requete->fetch(PDO::FETCH_ASSOC);
        return (int)($result['n_joueur'] ?? 0);
    }

    function getParticipantsByMatchId(int $id_match){
        $reqSQL = "SELECT p.id_joueur, u.nom, u.prenom, u.nom_util, j.mail, j.tel, n.libéllé AS niveau
                   FROM participe p
                   JOIN joueur j ON p.id_joueur = j.id_joueur
                   JOIN utilisateur u ON j.id_utilisateur = u.id_utilisateur
                   LEFT JOIN niveau n ON j.id_niv = n.id_niv
                   WHERE p.id_match = :id_match
                   ORDER BY u.nom ASC, u.prenom ASC;";
        $requete = dataBase::get()->prepare($reqSQL);
        $requete->BindValue(':id_match', $id_match, PDO::PARAM_INT);
        $requete->execute();
        return $requete->fetchAll(PDO::FETCH_ASSOC);
    }
}