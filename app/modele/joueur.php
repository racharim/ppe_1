<?php
require_once __DIR__ . '/../../config/database.php';

class joueurModele {
    private int $id_joueur;
    private string $tel;
    private string $mail;
    private int $idNiveau;
    private int $id_utilisateur;

    function __construct($tel, $mail, $idNiveau, $id_utilisateur){
        $this->tel = $tel;
        $this->mail = $mail;
        $this->idNiveau = (int)$idNiveau;
        $this->id_utilisateur = (int)$id_utilisateur;
        $this->id_joueur = 0; // Will be set when saved to DB
    }

    public static function fromUserId(int $uid): self
        {
            $inst = new self('', '', 0, $uid);

            $data = $inst->getjoueurByUId($uid);
            if ($data) {
                $inst->id_joueur      = (int) ($data['id_joueur'] ?? 0);
                $inst->tel            = $data['tel']    ?? '';
                $inst->mail           = $data['mail']   ?? '';
                $inst->idNiveau       = (int) ($data['id_niv'] ?? 0);
            }

            return $inst;
        }

    function getIdJoueur() : int {
        return $this->id_joueur;
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

    function setIdJoueur(int $id_joueur) : void {
        $this->id_joueur = $id_joueur;
    }

    function setTel(string $tel) : void {
        $this->tel = $tel;
    }

    function setMail(string $mail) : void {
        $this->mail = $mail;
    }

    function setIdNiveau(int $idNiveau) : void {
        $this->idNiveau = $idNiveau;
    }

    function setIdUtilisateur(int $id_utilisateur) : void {
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
        $reqSQL="INSERT INTO joueur (tel, mail, id_Niv, id_utilisateur) VALUES (:tel, :mail, :idNiveau, :id_utilisateur);";
        $requete = dataBase::get()->prepare($reqSQL);
        $requete->BindValue(':tel',$joueur->tel,PDO::PARAM_STR);
        $requete->BindValue(':mail',$joueur->mail,PDO::PARAM_STR);
        $requete->BindValue(':idNiveau',$joueur->idNiveau,PDO::PARAM_INT);
        $requete->BindValue(':id_utilisateur',$joueur->id_utilisateur,PDO::PARAM_INT);
        $requete->execute();
    } 
    
    function updateJoueur(){
        $reqSQL="UPDATE joueur SET tel = :tel, mail = :mail, id_Niv = :idNiveau WHERE id_joueur = :id_joueur;";
        $requete = dataBase::get()->prepare($reqSQL);
        $requete->BindValue(':tel',$this->tel,PDO::PARAM_STR);
        $requete->BindValue(':mail',$this->mail,PDO::PARAM_STR);
        $requete->BindValue(':idNiveau',$this->idNiveau,PDO::PARAM_INT);
        $requete->BindValue(':id_joueur',$this->id_joueur,PDO::PARAM_INT);
        $requete->execute();
    }
}

    