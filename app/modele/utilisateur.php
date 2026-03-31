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
        $reqSQL="SELECT * FROM utilisateur WHERE nom_util = :login;";
        $requete = dataBase::get()->prepare($reqSQL);
        $requete->BindValue(':login',$login,PDO::PARAM_STR);
        $requete->execute();
        $util = $requete->fetch(PDO::FETCH_ASSOC);
        
        // Vérifier si l'utilisateur existe et si le mot de passe correspond au hash (ou s'il correspond au mdp en clair pour rétrocompatibilité temporaire, bien que ce soit déconseillé)
        if ($util && password_verify($mdp, $util['mdp'])) {
            $this->hydrate($util);
            return $util;
        } else if ($util && $util['mdp'] === $mdp) {
            // Optionnel : Permet de se connecter avec un ancien mdp non hashé (les vieux comptes marcheront encore)
            $this->hydrate($util);
            return $util;
        }
        
        return false;
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

    function isLoginTaken(string $login): bool {
        $reqSQL="SELECT COUNT(*) as count FROM utilisateur WHERE nom_util = :login;";
        $requete = dataBase::get()->prepare($reqSQL);
        $requete->BindValue(':login', $login, PDO::PARAM_STR);
        $requete->execute();
        $result = $requete->fetch(PDO::FETCH_ASSOC);
        return $result['count'] > 0;
    }

    function AjouterUtilisateur() : void{
        $reqSQL="INSERT INTO utilisateur (nom_util, mdp, nom, prenom, type_compte) VALUES (:login, :mdp, :nom, :prenom, :type_compte);";
        $requete = dataBase::get()->prepare($reqSQL);
        // utiliser les accesseurs pour récupérer les valeurs
        $requete->BindValue(':login',$this->getLogin(),PDO::PARAM_STR);
        $requete->BindValue(':mdp',password_hash($this->getMdp(), PASSWORD_DEFAULT),PDO::PARAM_STR);
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

    function updateDateConnexion() : void {
        $reqSQL="UPDATE utilisateur SET derniere_connexion = NOW() WHERE id_utilisateur = :id;";
        $requete = dataBase::get()->prepare($reqSQL);
        $requete->BindValue(':id', $this->getId(), PDO::PARAM_INT);
        $requete->execute();
    }

    function getOldestConnectedPlayers() {
        $reqSQL = "SELECT nom, prenom, derniere_connexion 
                   FROM utilisateur 
                   WHERE type_compte = 1 AND derniere_connexion IS NOT NULL
                   ORDER BY derniere_connexion ASC 
                   LIMIT 5;";
        $requete = dataBase::get()->prepare($reqSQL);
        $requete->execute();
        return $requete->fetchAll(PDO::FETCH_ASSOC);
    }

    function getAllJoueurs() {
        $reqSQL = "SELECT id_utilisateur, nom, prenom, nom_util FROM utilisateur WHERE type_compte = 1 ORDER BY nom ASC;";
        $requete = dataBase::get()->prepare($reqSQL);
        $requete->execute();
        return $requete->fetchAll(PDO::FETCH_ASSOC);
    }

    function getAllCoachs() {
        $reqSQL = "SELECT id_utilisateur, nom, prenom, nom_util FROM utilisateur WHERE type_compte = 2 ORDER BY nom ASC;";
        $requete = dataBase::get()->prepare($reqSQL);
        $requete->execute();
        return $requete->fetchAll(PDO::FETCH_ASSOC);
    }

    function deleteJoueurComplet(int $id_utilisateur) {
        // Obtenir l'id_joueur depuis l'utilisateur
        $reqSQL = "SELECT id_joueur FROM joueur WHERE id_utilisateur = :id_utilisateur;";
        $requete = dataBase::get()->prepare($reqSQL);
        $requete->BindValue(':id_utilisateur', $id_utilisateur, PDO::PARAM_INT);
        $requete->execute();
        $joueur = $requete->fetch(PDO::FETCH_ASSOC);

        if ($joueur) {
            $id_joueur = $joueur['id_joueur'];
            // 1. Supprimer les participations aux matchs
            $req1 = dataBase::get()->prepare("DELETE FROM participe WHERE id_joueur = :id_joueur;");
            $req1->BindValue(':id_joueur', $id_joueur, PDO::PARAM_INT);
            $req1->execute();

            // 2. Supprimer les favoris
            $req2 = dataBase::get()->prepare("DELETE FROM favoris WHERE id_joueur = :id_joueur;");
            $req2->BindValue(':id_joueur', $id_joueur, PDO::PARAM_INT);
            $req2->execute();

            // 3. Supprimer de la table joueur
            $req3 = dataBase::get()->prepare("DELETE FROM joueur WHERE id_joueur = :id_joueur;");
            $req3->BindValue(':id_joueur', $id_joueur, PDO::PARAM_INT);
            $req3->execute();
        }

        // 4. Supprimer l'utilisateur
        $req4 = dataBase::get()->prepare("DELETE FROM utilisateur WHERE id_utilisateur = :id_utilisateur;");
        $req4->BindValue(':id_utilisateur', $id_utilisateur, PDO::PARAM_INT);
        $req4->execute();
    }

    function deleteCoachComplet(int $id_utilisateur) {
        // 1. Supprimer de la table coach
        $req1 = dataBase::get()->prepare("DELETE FROM coach WHERE id_utilisateur = :id_utilisateur;");
        $req1->BindValue(':id_utilisateur', $id_utilisateur, PDO::PARAM_INT);
        $req1->execute();

        // 2. Supprimer l'utilisateur
        $req2 = dataBase::get()->prepare("DELETE FROM utilisateur WHERE id_utilisateur = :id_utilisateur;");
        $req2->BindValue(':id_utilisateur', $id_utilisateur, PDO::PARAM_INT);
        $req2->execute();
    }
}