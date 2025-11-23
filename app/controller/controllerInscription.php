<?php
require_once '../../app/modele/utilisateur.php';
require_once '../../app/modele/joueur.php';

$nom = $_POST['Nom'];
$prenom = $_POST['Prenom'];
$login = $_POST['login'];
$tel = $_POST['tel'];
$mail = $_POST['mail'];
$mdp = $_POST['Mdp'];
$mdp2 = $_POST['Mdp2'];
$idNiveau = $_POST['niv'];

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

if ($mdp !== $mdp2) {
    $error="Les mots de passe ne correspondent pas. Veuillez réessayer.";
    header('Location: /ppe_1/app/vue/inscription.php?error=' . $error);
    exit();
}else{
    $hashed = password_hash($mdp, PASSWORD_DEFAULT);
    $monUtilisateur = new UtilisateurModele($login, $hashed);
    $monUtilisateur->AjouterUtilisateur();
    $monJoueur = new joueurModele ($nom, $prenom, $tel, $mail, $idNiveau, $monUtilisateur->getLastIdUtilisateur());
    $monJoueur->createJoueur($monJoueur);
    header('Location: ../../public/index.php');
    exit();
}

