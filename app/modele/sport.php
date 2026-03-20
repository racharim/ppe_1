<?php

require_once __DIR__ .'/../../config/database.php';

class SportModele {
    
    function getAllSports(){
        $reqSQL="SELECT * FROM sport ;";
        $requete = dataBase::get()->prepare($reqSQL);
        $requete->execute();
        $sports = $requete->fetchAll(PDO::FETCH_ASSOC);
        return $sports;
    }

    function getSportByName(string $name){
        $reqSQL="SELECT * FROM sport WHERE nom = :name ;";
        $requete = dataBase::get()->prepare($reqSQL);
        $requete->BindValue(':name',$name,PDO::PARAM_STR);
        $requete->execute();
        $sport = $requete->fetchall(PDO::FETCH_ASSOC);
        return $sport;
    } 

    function getSportById(int $id){
        $reqSQL="SELECT * FROM sport WHERE id_sport = :id ;";
        $requete = dataBase::get()->prepare($reqSQL);
        $requete->BindValue(':id',$id,PDO::PARAM_INT);
        $requete->execute();
        $sport = $requete->fetch(PDO::FETCH_ASSOC);
        return $sport;
    }

    function addSport(string $nom, int $n_joueur, string $descriptif) {
        $reqSQL = "INSERT INTO sport (nom, n_joueur, descriptif) VALUES (:nom, :n_joueur, :descriptif);";
        $requete = dataBase::get()->prepare($reqSQL);
        $requete->bindValue(':nom', $nom, PDO::PARAM_STR);
        $requete->bindValue(':n_joueur', $n_joueur, PDO::PARAM_INT);
        $requete->bindValue(':descriptif', $descriptif, PDO::PARAM_STR);
        return $requete->execute();
    }

    function getStatsJoueursParSport() {
        $reqSQL = "SELECT s.nom, COUNT(DISTINCT f.id_joueur) as count_joueurs 
                   FROM sport s
                   LEFT JOIN favoris f ON s.id_sport = f.id_sport
                   GROUP BY s.id_sport, s.nom
                   ORDER BY count_joueurs DESC;";
        $requete = dataBase::get()->prepare($reqSQL);
        $requete->execute();
        return $requete->fetchAll(PDO::FETCH_ASSOC);
    }

    function deleteSportComplet(int $id_sport) {
        $db = dataBase::get();
        // 1. Delete participations to matches of this sport
        $req1 = $db->prepare("DELETE FROM participe WHERE id_match IN (SELECT id_match FROM match_ WHERE id_sport = :id_sport);");
        $req1->BindValue(':id_sport', $id_sport, PDO::PARAM_INT);
        $req1->execute();

        // 2. Delete matches of this sport
        $req2 = $db->prepare("DELETE FROM match_ WHERE id_sport = :id_sport;");
        $req2->BindValue(':id_sport', $id_sport, PDO::PARAM_INT);
        $req2->execute();

        // 3. Delete favoris of this sport
        $req3 = $db->prepare("DELETE FROM favoris WHERE id_sport = :id_sport;");
        $req3->BindValue(':id_sport', $id_sport, PDO::PARAM_INT);
        $req3->execute();

        // 4. Delete coaches teaching this sport
        $req4 = $db->prepare("SELECT id_utilisateur FROM coach WHERE id_sport = :id_sport;");
        $req4->BindValue(':id_sport', $id_sport, PDO::PARAM_INT);
        $req4->execute();
        $coaches = $req4->fetchAll(PDO::FETCH_ASSOC);

        $req5 = $db->prepare("DELETE FROM coach WHERE id_sport = :id_sport;");
        $req5->BindValue(':id_sport', $id_sport, PDO::PARAM_INT);
        $req5->execute();

        if (!empty($coaches)) {
            $reqUtil = $db->prepare("DELETE FROM utilisateur WHERE id_utilisateur = :id_utilisateur;");
            foreach($coaches as $coach) {
                $reqUtil->BindValue(':id_utilisateur', $coach['id_utilisateur'], PDO::PARAM_INT);
                $reqUtil->execute();
            }
        }

        // 5. Delete the sport itself
        $req6 = $db->prepare("DELETE FROM sport WHERE id_sport = :id_sport;");
        $req6->BindValue(':id_sport', $id_sport, PDO::PARAM_INT);
        $req6->execute();
    }
}