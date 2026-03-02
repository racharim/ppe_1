<?php
require_once '../../app/modele/utilisateur.php';
require_once '../../app/modele/joueur.php';
require_once '../../app/vue/connexion.php';
require_once '../../app/modele/coach.php';
require_once '../../app/modele/admin.php';

if (!empty($_POST)) {
    $login = $_POST['login'];
    $mdp = $_POST['mdp'];

    $utilisateurModele = new UtilisateurModele($login, $mdp);
    $utilisateur = $utilisateurModele->getUtil($login, $mdp);

    if ($utilisateur['mdp']==$mdp) {
     session_start();
        $_SESSION['utilisateur_id'] = $utilisateur['id_utilisateur'];
        $_SESSION['utilisateur_login'] = $utilisateur['mdp'];
        $_SESSION['utilisateur_type'] = $utilisateur['type_compte'];
        
        if($utilisateur['type_compte']== 1){
            $joueurModele = new joueurModele($utilisateur['id_utilisateur']);
            $_SESSION['joueur'] = $joueurModele;
        }else if($utilisateur['type_compte']== 2){
            $coachModele = new coachModele($utilisateur['id_utilisateur']);
            $_SESSION['coach'] = $coachModele;
        }else if($utilisateur['type_compte']== 3){
            $adminModele = new adminModele($utilisateur['id_utilisateur']);
            $_SESSION['admin'] = $adminModele;
        }
        header('Location: ../controller/controllerAccueil.php');

        exit();
    } else {
        // Échec de la connexion
        $error = "Login ou mot de passe incorrect.";
       
    }
}