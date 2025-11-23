<?php
require_once '../../config/database.php';

class joueurModele {
    private int $id_joueur;
    private string $nom;
    private string $prenom;
    private string $tel;
    private string $mail;
    private int $idNiveau;
    private int $id_utilisateur;

    function __construct( $nom, $prenom, $tel, $mail, $idNiveau, $id_utilisateur ){
        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->tel = $tel;
        $this->mail = $mail;
        $this->idNiveau = $idNiveau;
        $this->id_utilisateur = $id_utilisateur;
    }

    function getjoueurByUId(int $id){
        $reqSQL="SELECT * FROM joueur WHERE id_utilisateur  = :id ;";
        $requete = dataBase::get()->prepare($reqSQL);
        $requete->BindValue(':id',$id,PDO::PARAM_INT);
        $requete->execute();
        $joueur = $requete->fetch(PDO::FETCH_ASSOC);
        return $joueur;
    }

    function createJoueur(joueurModele $joueur){
        $reqSQL="INSERT INTO joueur (nom, prenom, tel, mail, id_Niv, id_utilisateur) VALUES (:nom, :prenom, :tel, :mail, :idNiveau, :id_utilisateur);";
        $requete = dataBase::get()->prepare($reqSQL);
        $requete->BindValue(':nom',$joueur->nom,PDO::PARAM_STR);
        $requete->BindValue(':prenom',$joueur->prenom,PDO::PARAM_STR);
        $requete->BindValue(':tel',$joueur->tel,PDO::PARAM_STR);
        $requete->BindValue(':mail',$joueur->mail,PDO::PARAM_STR);
        $requete->BindValue(':idNiveau',$joueur->idNiveau,PDO::PARAM_INT);
        $requete->BindValue(':id_utilisateur',$joueur->id_utilisateur,PDO::PARAM_INT);
        $requete->execute();
    }    
}

    