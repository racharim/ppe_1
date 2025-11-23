<?php
require_once '../../config/database.php';

class UtilisateurModele {
    private int $identifiant;
    private String $mdp;
    private String $login;

    function __construct($login, $mdp ){
        $this->login = $login;
        $this->mdp = $mdp;
    }
    
    function getId() : int {
        return $this->identifiant;
    }

    function getLogin() : String {
        return $this->login;
    }

    function getMdp() : String {
        return $this->mdp;
    }

    function setLogin(String $login) : void {
        $this->login = $login;
    }

    function setMdp(String $mdp) : void {
        $this->mdp = $mdp;
    }

    function setId(int $id) : void {
        $this->identifiant = $id;
    }

    function getUtil(String $login, String $mdp){
        $reqSQL="SELECT * FROM utilisateur WHERE nom_util = :login AND mdp = :mdp ;";
        $requete = dataBase::get()->prepare($reqSQL);
        $requete->BindValue(':login',$login,PDO::PARAM_STR);
        $requete->BindValue(':mdp',$mdp,PDO::PARAM_STR);
        $requete->execute();
        $util = $requete->fetch(PDO::FETCH_ASSOC);
        return $util;
    }
    

    function getUtilisateurById(string $id){
        $reqSQL="SELECT * FROM utilisateur WHERE id_utilisateur = :id ;";
        $requete = dataBase::get()->prepare($reqSQL);
        $requete->BindValue(':id',$id,PDO::PARAM_STR);
        $requete->execute();
        $utilisateur = $requete->fetch(PDO::FETCH_ASSOC);
        return $utilisateur;
    }

    function AjouterUtilisateur() : void{
        $reqSQL="INSERT INTO utilisateur (nom_util, mdp) VALUES (:login, :mdp);";
        $requete = dataBase::get()->prepare($reqSQL);
        // use getters to retrieve values
        $requete->BindValue(':login',$this->getLogin(),PDO::PARAM_STR);
        $requete->BindValue(':mdp',$this->getMdp(),PDO::PARAM_STR);
        $requete->execute();
    }

    function getLastIdUtilisateur() : int{
        $reqSQL="SELECT MAX(id_utilisateur) AS max_id FROM utilisateur;";
        $requete = dataBase::get()->prepare($reqSQL);
        $requete->execute();
        $result = $requete->fetch(PDO::FETCH_ASSOC);
        return $result['max_id'];
    }
}