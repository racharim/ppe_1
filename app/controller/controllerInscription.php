<?php
require_once __DIR__ . '/../modele/utilisateur.php';
require_once __DIR__ . '/../modele/joueur.php';
require_once __DIR__ . '/../vue/inscription.php';

if (!empty($_POST)) {
    $errors = []; // Tableau pour collecter toutes les erreurs
    
    $nom = $_POST['Nom'];
    $prenom = $_POST['Prenom'];
    $login = $_POST['login'];
    $tel = $_POST['tel'];
    $mail = $_POST['mail'];
    $mdp = $_POST['Mdp'];
    $mdp2 = $_POST['Mdp2'];
    $idNiveau = $_POST['niv'];

    $patternMail = "/[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,}/i";
    $patternTel = "/(0|\\+33|0033)[1-9][0-9]{8}/";

    // Vérifier l'email
    if(preg_match($patternMail, $mail) == 0){
        $errors[] = "L'adresse email n'est pas valide.";
    }

    // Vérifier le téléphone
    if(preg_match($patternTel, $tel) == 0){
        $errors[] = "Le numéro de téléphone n'est pas valide.";
    }

    // Vérifier la correspondance des mots de passe
    if ($mdp !== $mdp2) {
        $errors[] = "Les mots de passe ne correspondent pas.";
    }

    // Vérifier la complexité du mot de passe (8 carac, 1 MAJ, 1 chiffre, 1 spécial)
    $patternMdp = '/^(?=.*[A-Z])(?=.*\d)(?=.*[^a-zA-Z\d]).{8,}$/';
    if (!preg_match($patternMdp, $mdp)) {
        $errors[] = "Le mot de passe doit contenir au moins 8 caractères, dont 1 majuscule, 1 chiffre et 1 caractère spécial.";
    }

    // Vérifier l'unicité du login
    $tempUtil = new UtilisateurModele('', '');
    if ($tempUtil->isLoginTaken($login)) {
        $errors[] = "Ce pseudo (login) est déjà pris, veuillez en choisir un autre.";
    }

    // Si des erreurs existent, stocker en session et rediriger
    if (!empty($errors)) {
        $_SESSION['errors'] = $errors;
        header('Location: /ppe_1/public/index.php?page=inscription');
        exit();
    }

    // Pas d'erreurs, continuer avec l'inscription
    switch ($idNiveau) {
        case 'debutant':
            $idNiveau= 1;
            break;
        
        case 'intermediaire':
            $idNiveau= 2;
            break;
        case 'expert':
            $idNiveau= 3;
            break;    
    }

    $monUtilisateur = new UtilisateurModele($login, $mdp);
    $monUtilisateur->setNom($nom);
    $monUtilisateur->setPrenom($prenom);
    $monUtilisateur->setTypeCompte(1);
    $monUtilisateur->AjouterUtilisateur();
    $monUtilisateur->setId($monUtilisateur->getLastIdUtilisateur());
    $_SESSION['utilisateur']=$monUtilisateur;
    $monJoueur = new joueurModele ($tel, $mail, $idNiveau, $monUtilisateur->getLastIdUtilisateur());
    $monJoueur->createJoueur($monJoueur);
    $_SESSION['joueur'] = $monJoueur;
    header('Location: /ppe_1/public/index.php?page=accueil');
    exit();
}
