<?php
require_once __DIR__ . '/../../config/database.php';

class UtilisateurModele {
    private int $identifiant = 0;
    private String $mdp = '';
    private String $login = '';
    private String $nom = '';
    private String $prenom = '';
    private int $type_compte = 1;

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

    function getNom() : string {
        return $this->nom;
    }

    function getPrenom() : string {
        return $this->prenom;
    }

    function getTypeCompte() : int {
        return $this->type_compte;
    }

    function setLogin(string $login) : void {
        $this->login = $login;
    }

    function setMdp(string $mdp) : void {
        $this->mdp = $mdp;
    }

    function setNom(string $nom) : void {
        $this->nom = $nom;
    }

    function setPrenom(string $prenom) : void {
        $this->prenom = $prenom;
    }

    function setTypeCompte(int $type_compte) : void {
        $this->type_compte = $type_compte;
    }

    function setId(int $id) : void {
        $this->identifiant = $id;
    }

    private function hydrate(array $utilisateur) : void {
        $this->identifiant = (int)($utilisateur['id_utilisateur'] ?? 0);
        $this->login = $utilisateur['nom_util'] ?? '';
        $this->mdp = $utilisateur['mdp'] ?? '';
        $this->nom = $utilisateur['nom'] ?? '';
        $this->prenom = $utilisateur['prenom'] ?? '';
        $this->type_compte = (int)($utilisateur['type_compte'] ?? 1);
    }

    function getUtil(String $login, String $mdp){
        $reqSQL="SELECT * FROM utilisateur WHERE nom_util = :login AND mdp = :mdp ;";
        $requete = dataBase::get()->prepare($reqSQL);
        $requete->BindValue(':login',$login,PDO::PARAM_STR);
        $requete->BindValue(':mdp',$mdp,PDO::PARAM_STR);
        $requete->execute();
        $util = $requete->fetch(PDO::FETCH_ASSOC);
        if ($util) {
            $this->hydrate($util);
        }
        return $util;
    }
    

    function getUtilisateurById(string $id){
        $reqSQL="SELECT * FROM utilisateur WHERE id_utilisateur = :id ;";
        $requete = dataBase::get()->prepare($reqSQL);
        $requete->BindValue(':id',$id,PDO::PARAM_STR);
        $requete->execute();
        $utilisateur = $requete->fetch(PDO::FETCH_ASSOC);
        if ($utilisateur) {
            $this->hydrate($utilisateur);
        }
        return $utilisateur;
    }

    function AjouterUtilisateur() : void{
        $reqSQL="INSERT INTO utilisateur (nom_util, mdp, nom, prenom, type_compte) VALUES (:login, :mdp, :nom, :prenom, :type_compte);";
        $requete = dataBase::get()->prepare($reqSQL);
        // use getters to retrieve values
        $requete->BindValue(':login',$this->getLogin(),PDO::PARAM_STR);
        $requete->BindValue(':mdp',$this->getMdp(),PDO::PARAM_STR);
        $requete->BindValue(':nom',$this->getNom(),PDO::PARAM_STR);
        $requete->BindValue(':prenom',$this->getPrenom(),PDO::PARAM_STR);
        $requete->BindValue(':type_compte',$this->getTypeCompte(),PDO::PARAM_INT);
        $requete->execute();
    }

    function getLastIdUtilisateur() : int{
        $reqSQL="SELECT MAX(id_utilisateur) AS max_id FROM utilisateur;";
        $requete = dataBase::get()->prepare($reqSQL);
        $requete->execute();
        $result = $requete->fetch(PDO::FETCH_ASSOC);
        return $result['max_id'];
    }

    function updateUtilisateur() : void {
        $reqSQL="UPDATE utilisateur SET nom = ?, prenom = ? WHERE id_utilisateur = ?;";
        $requete = dataBase::get()->prepare($reqSQL);
        $requete->execute([
            $this->getNom(),
            $this->getPrenom(),
            $this->getId()
        ]);
    }
}