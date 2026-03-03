<?php
// Démarrer la session s'il n'y en a pas déjà (gérée par front controller)
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Supprimer toutes les variables de session
$_SESSION = array();

// Détruire la session elle-même
session_destroy();

// Rediriger vers la page de connexion via le front controller
header('Location: /ppe_1/public/index.php?page=connexion');
exit();
?>
