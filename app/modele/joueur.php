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

    function __construct($id_utilisateur){
        $this->id_utilisateur = $id_utilisateur;
        $this->id_joueur = $this.getjoueurByUId($id_utilisateur)['id_joueur'];
        $this->nom = $this.getjoueurByUId($id_utilisateur)['nom'];
        $this->prenom = $this.getjoueurByUId($id_utilisateur)['prenom'];
        $this->tel = $this.getjoueurByUId($id_utilisateur)['tel'];
        $this->mail = $this.getjoueurByUId($id_utilisateur)['mail'];
        $this->idNiveau = $this.getjoueurByUId($id_utilisateur)['id_Niv'];

    }

    function getIdJoueur() : int {
        return $this->id_joueur;
    }

    function getNom() : string {
        return $this->nom;
    }

    function getPrenom() : string {
        return $this->prenom;
    } 

    function getTel() : string {
        return $this->tel;
    }    

    function getMail() : string {
        return $this->mail;
    }

    function getIdNiveau() : int {
        return $this->idNiveau;
    }

    function getIdUtilisateur() : int {
        return $this->id_utilisateur;
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

    