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
        $this->id_sport = '';
        
        $coach = $this->getcoachByUId($id_utilisateur);
        if ($coach) {
            $this->id_coach = $coach['id_coach'] ?? 0;
            $this->nom = $coach['nom'] ?? '';
            $this->prenom = $coach['prenom'] ?? '';
            $this->sport = $coach['sport'] ?? '';
            $this->id_sport = $coach['id_sport'] ?? '';
        }
    }


    function getcoachByUId(int $id){
        $reqSQL="SELECT * FROM coach WHERE id_utilisateur  = :id ;";
        $requete = dataBase::get()->prepare($reqSQL);
        $requete->BindValue(':id',$id,PDO::PARAM_INT);
        $requete->execute();
        $coach = $requete->fetch(PDO::FETCH_ASSOC);
        return $coach;
    }
}