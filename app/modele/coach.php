<?php
require_once __DIR__ . '/../../config/database.php';

class coachModele {
    private int $id_coach;
    private string $nom;
    private string $prenom;
    private string $sport;
    private int $id_sport;
    private int $id_utilisateur;

    function __construct($id_utilisateur){
        $this->id_utilisateur = $id_utilisateur;
        $this->id_coach = 0;
        $this->nom = '';
        $this->prenom = '';
        $this->sport = '';
        $this->id_sport = 0;
        
        $coach = $this->getcoachByUId($id_utilisateur);
        if ($coach) {
            $this->id_coach = $coach['id_coach'] ?? 0;
            $this->nom = $coach['nom'] ?? '';
            $this->prenom = $coach['prenom'] ?? '';
            $this->sport = $coach['sport'] ?? '';
            $this->id_sport = $coach['id_sport'] ?? 0;
        }
    }

    function getIdCoach() : int { return $this->id_coach; }
    function getNom() : string { return $this->nom; }
    function getPrenom() : string { return $this->prenom; }
    function getSport() : string { return $this->sport; }
    function getIdSport() : int { return $this->id_sport; }
    function getIdUtilisateur() : int { return $this->id_utilisateur; }

    function setNom(string $nom) : void { $this->nom = $nom; }
    function setPrenom(string $prenom) : void { $this->prenom = $prenom; }
    function setSport(string $sport) : void { $this->sport = $sport; }
    function setIdSport(int $id_sport) : void { $this->id_sport = $id_sport; }

    function getcoachByUId(int $id){
        $reqSQL="SELECT * FROM coach WHERE id_utilisateur  = :id ;";
        $requete = dataBase::get()->prepare($reqSQL);
        $requete->BindValue(':id',$id,PDO::PARAM_INT);
        $requete->execute();
        $coach = $requete->fetch(PDO::FETCH_ASSOC);
        return $coach;
    }

    function createCoach(){
        $reqSQL="INSERT INTO coach (sport, id_sport, id_utilisateur) VALUES (:sport, :id_sport, :id_utilisateur);";
        $requete = dataBase::get()->prepare($reqSQL);
        $requete->BindValue(':sport',$this->sport,PDO::PARAM_STR);
        $requete->BindValue(':id_sport',$this->id_sport,PDO::PARAM_INT);
        $requete->BindValue(':id_utilisateur',$this->id_utilisateur,PDO::PARAM_INT);
        $requete->execute();
    }
}