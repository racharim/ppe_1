<?php
// Démarrer la session si elle n'est pas encore démarrée
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Supprimer toutes les variables de session
$_SESSION = array();

// Détruire la session elle-même
session_destroy();

// Rediriger vers la page d'accueil ou de connexion
header('Location: ../controller/controllerConnexion.php');
exit();
?>
