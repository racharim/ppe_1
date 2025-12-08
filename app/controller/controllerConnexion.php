<?php
require_once '../../app/modele/utilisateur.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $login = $_POST['login'];
    $mdp = $_POST['mdp'];

    $utilisateurModele = new UtilisateurModele($login, $mdp);
    $utilisateur = $utilisateurModele->getUtil($login, $mdp);

    if ($utilisateur['mdp']==$mdp) {
        // Connexion réussie
        session_start();
        $_SESSION['utilisateur_id'] = $utilisateur['id_utilisateur'];
        $_SESSION['utilisateur_login'] = $utilisateur['mdp'];
        header('Location: ../../app/vue/accueil.php');
        exit();
    } else {
        // Échec de la connexion
        $error = "Login ou mot de passe incorrect.";
        header('Location: /ppe_1/app/vue/connexion.php');
    }
}