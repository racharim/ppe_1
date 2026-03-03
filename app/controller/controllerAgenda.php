<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// charge le modèle des matchs pour récupérer les événements
require_once __DIR__ . '/../modele/match.php';

$matchModel = new matchModele();
// on passe le timestamp complet (date + heure) car la colonne est de type DATETIME
$matches = $matchModel->getAllNextMatchs(date('Y-m-d H:i:s'));

// transforme les résultats en tableau utilisé par FullCalendar
$events = [];
foreach ($matches as $m) {
    $events[] = [
        'title' => $m['libéllé'] ?? 'Match',
        'start' => $m['date_debut'] ?? '',
        // si vous avez une page de détails, on peut l'ajouter ici
        // 'url'   => '?page=match&id=' . ($m['id_match'] ?? 0),
    ];
}

// encoder en JSON pour l'injecter dans la vue
$eventsJson = json_encode($events);

// inclusion de la vue (la vue incorpore son propre header)
require_once __DIR__ . '/../vue/agenda.php';
