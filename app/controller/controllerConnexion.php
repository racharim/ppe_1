<?php
require_once '../../app/modele/utilisateur.php';
require_once '../../app/modele/joueur.php';
require_once '../../app/vue/connexion.php';

if (!empty($_POST)) {
    $login = $_POST['login'];
    $mdp = $_POST['mdp'];

    $utilisateurModele = new UtilisateurModele($login, $mdp);
    $utilisateur = $utilisateurModele->getUtil($login, $mdp);

    if ($utilisateur['mdp']==$mdp) {
        // Connexion réussie
        session_start();
        $_SESSION['utilisateur_id'] = $utilisateur['id_utilisateur'];
        $_SESSION['utilisateur_login'] = $utilisateur['mdp'];
        $joueurModele = new joueurModele($utilisateur['id_utilisateur']);
        $_SESSION['joueur'] = $joueurModele;
        header('Location: ../../app/vue/accueil.php');
        exit();
    } else {
        // Échec de la connexion
        $error = "Login ou mot de passe incorrect.";
        header('Location: /ppe_1/app/vue/connexion.php');
    }
}