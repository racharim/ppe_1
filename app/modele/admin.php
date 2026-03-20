<?php
require_once __DIR__ . '/../../config/database.php';

class adminModele {
    private int $id_admin;
    private int $id_utilisateur;

    function __construct($id_utilisateur){
        $this->id_utilisateur = $id_utilisateur;
        $this->id_admin = 0; // Il n'y a plus de table admin, donc pas de vrai id_admin
    }
}