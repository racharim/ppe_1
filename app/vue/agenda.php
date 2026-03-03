<?php
// la variable $eventsJson est fournie par le contrôleur.
if (!isset($eventsJson)) {
    $eventsJson = '[]';
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agenda des matchs</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@picocss/pico@1/css/pico.min.css">
    <link rel="stylesheet" href="/ppe_1/config/pico.css">
    <!-- utilisation de fichiers locaux plutôt que CDN (réseau peut être coupé) -->
    <link id="fc-css" href="/ppe_1/public/fullcalendar/main.min.css" rel="stylesheet" />
    <script src="/ppe_1/public/fullcalendar/dist/index.global.min.js"></script>

    <style>
        /* juste un peu de style pour centrer le calendrier et assurer une hauteur minimale */
        #calendar {
            max-width: 900px;
            margin: 40px auto;
            height: 700px;
        }
    </style>
</head>
<body>
<main>
  <header>
    <?php include __DIR__ . '/partial/header.php'; ?>
  </header>

  <div id="calendar"></div>
</main>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        console.log('DOMContentLoaded fired, FullCalendar=', window.FullCalendar);
        console.log('eventsJson=', <?php echo $eventsJson; ?>);
        var calendarEl = document.getElementById('calendar');
        if (!calendarEl) {
            console.error('#calendar element not found');
            return;
        }

        if (!window.FullCalendar) {
            console.error('FullCalendar library not loaded');
            return;
        }

        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            locale: 'fr',
            events: <?php echo $eventsJson; ?>
        });
        calendar.render();
        console.log('calendar rendered');
    });
</script>

</main>
</body>
</html>
