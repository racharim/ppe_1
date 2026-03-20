<?php
require_once __DIR__ . '/../modele/utilisateur.php';
require_once __DIR__ . '/../modele/joueur.php';
require_once __DIR__ . '/../vue/connexion.php';
require_once __DIR__ . '/../modele/coach.php';
require_once __DIR__ . '/../modele/admin.php';

if (!empty($_POST)) {
    $login = $_POST['login'];
    $mdp = $_POST['mdp'];

    $utilisateurModele = new UtilisateurModele($login, $mdp);
    $utilisateur = $utilisateurModele->getUtil($login, $mdp);

    if ($utilisateur && isset($utilisateur['mdp']) && $utilisateur['mdp'] == $mdp) {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        $utilisateurModele->setId($utilisateur['id_utilisateur']);
        $utilisateurModele->updateDateConnexion();
        
        $_SESSION['utilisateur'] = $utilisateurModele; // Stocker les données de l'utilisateur dans la session
        
        if($utilisateurModele->getTypeCompte() == 1){
            $joueurModele = joueurModele::fromUserId($utilisateurModele->getId());
            $_SESSION['joueur'] = $joueurModele;
        }else if($utilisateurModele->getTypeCompte() == 2){
            $coachModele = new coachModele($utilisateurModele->getId());
            $_SESSION['coach'] = $coachModele;
        }else if($utilisateurModele->getTypeCompte() == 3){
            $adminModele = new adminModele($utilisateurModele->getId());
            $_SESSION['admin'] = $adminModele;
        }
        // redirection vers l'accueil via front controller
        header('Location: /ppe_1/public/index.php?page=accueil');

        exit();
    } else {
        // Échec de la connexion
        $error = "Login ou mot de passe incorrect.";
       
    }
}