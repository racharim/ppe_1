<!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@picocss/pico@1/css/pico.min.css">
    <link rel="stylesheet" href="/ppe_1/config/pico.css">
  </head>
  <body>
    <main>
      <header>
        <?php require_once __DIR__ . '/partial/header.php'; ?>
      </header>
      
      <?php if($_SESSION['utilisateur_type'] == 1){ ?>
      
      <section class="section">
        <h3>🏆 Mes inscriptions</h3>
        <?php
        if (isset($matchs) && !empty($matchs)) {
            foreach ($matchs as $match) {
        ?>
          <div class="match-card">
            <div class="match-info">
              <span><strong><?php echo htmlspecialchars($match['libéllé'] ?? 'N/A'); ?></strong></span>
              <span>Début: <code><?php echo htmlspecialchars($match['date_debut'] ?? 'N/A'); ?></code></span>
              <span>Fin: <code><?php echo htmlspecialchars($match['date_fin'] ?? 'N/A'); ?></code></span>
            </div>
          </div>
        <?php
            }
        } else {
            echo '<p><em>Vous n\'avez aucune inscription pour le moment.</em></p>';
        }
        ?>
      </section>

      <section class="section">
        <h3>💫 Pour vous (Matchs recommandés)</h3>
        <?php
        if (isset($matchsRecommandes) && !empty($matchsRecommandes)) {
            foreach ($matchsRecommandes as $matchRec) {
        ?>
          <div class="event-card">
            <div class="match-info">
              <span><strong><?php echo htmlspecialchars($matchRec['nom_match'] ?? 'N/A'); ?></strong></span>
              <span>Date: <code><?php echo htmlspecialchars($matchRec['date_debut'] ?? 'N/A'); ?></code></span>
              <span>Description: <em><?php echo htmlspecialchars($matchRec['descriptif'] ?? 'N/A'); ?></em></span>
            </div>
          </div>
        <?php
            }
        } else {
            echo '<p><em>Aucun match recommandé pour le moment.</em></p>';
        }
        ?>
      </section>

      <?php } ?>
    </main>
  </body>
</html>