<?php
require_once '../../config/database.php';

class adminModele {
    private int $id_admin;
    private string $nom;
    private string $prenom;
    private int $id_utilisateur;

    function __construct($id_utilisateur){
        $this->id_utilisateur = $id_utilisateur;
        $this->id_admin = 0;
        $this->nom = '';
        $this->prenom = '';
        
        $admin = $this->getadminByUId($id_utilisateur);
        if ($admin) {
            $this->id_admin = $admin['id_admin'] ?? 0;
            $this->nom = $admin['nom'] ?? '';
            $this->prenom = $admin['prenom'] ?? '';
        }
    }

    function getadminByUId(int $id){
        $reqSQL="SELECT * FROM admin WHERE id_utilisateur  = :id ;";
        $requete = dataBase::get()->prepare($reqSQL);
        $requete->BindValue(':id',$id,PDO::PARAM_INT);
        $requete->execute();
        $admin = $requete->fetch(PDO::FETCH_ASSOC);
        return $admin;
    }
}