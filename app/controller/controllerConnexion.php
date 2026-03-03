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

    if ($utilisateur['mdp']==$mdp) {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $_SESSION['utilisateur_id'] = $utilisateur['id_utilisateur'];
        $_SESSION['utilisateur_login'] = $utilisateur['mdp'];
        $_SESSION['utilisateur_type'] = $utilisateur['type_compte'];
        
        if($utilisateur['type_compte']== 1){
            $joueurModele = joueurModele::fromUserId($utilisateur['id_utilisateur']);
            $_SESSION['joueur'] = $joueurModele;
        }else if($utilisateur['type_compte']== 2){
            $coachModele = new coachModele($utilisateur['id_utilisateur']);
            $_SESSION['coach'] = $coachModele;
        }else if($utilisateur['type_compte']== 3){
            $adminModele = new adminModele($utilisateur['id_utilisateur']);
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