<?php
// simple front controller pour BTS SIO –
// aucune autoload, seulement un switch sur la page demandée.

// charger les définitions de classes qui peuvent être stockées en session
require_once __DIR__ . '/../app/modele/utilisateur.php';
require_once __DIR__ . '/../app/modele/joueur.php';
require_once __DIR__ . '/../app/modele/coach.php';
require_once __DIR__ . '/../app/modele/admin.php';

session_start();

// identifie la page via un paramètre GET `page` ou par défaut la page accueil.
$page = $_GET['page'] ?? 'accueil';

switch ($page) {
    case 'agenda':
        require __DIR__ . '/../app/controller/controllerAgenda.php';
        break;

    case 'connexion':
        require __DIR__ . '/../app/controller/controllerConnexion.php';
        break;

    case 'compte':
        require __DIR__ . '/../app/controller/controllerCompte.php';
        break;

    case 'deconnexion':
        require __DIR__ . '/../app/controller/controllerDeconnexion.php';
        break;

    case 'inscription':
        require __DIR__ . '/../app/controller/controllerInscription.php';
        break;

    case 'pagesSports':
        require __DIR__ . '/../app/controller/controllerPagesSports.php';
        break;

    case 'accueil':
    default:
        require __DIR__ . '/../app/controller/controllerAccueil.php';
        break;
}
