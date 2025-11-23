<?php
require_once '../../app/modele/utilisateur.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $login = $_POST['login'];
    $mdp = $_POST['mdp'];

    $utilisateurModele = new UtilisateurModele($login, password($mdp));
    $utilisateur = $utilisateurModele->getUtil($login, password($mdp));

    if ($utilisateur['mdp']==password($mdp)) {
        // Connexion réussie
        session_start();
        $_SESSION['utilisateur_id'] = $utilisateur['id'];
        $_SESSION['utilisateur_login'] = $utilisateur['login'];
        header('Location: ../../public/index.php');
        exit();
    } else {
        // Échec de la connexion
        $error = "Login ou mot de passe incorrect.";
        header('Location: /ppe_1/app/vue/connexion.php');
    }
}