<!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mes Inscriptions</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@picocss/pico@1/css/pico.min.css">
    <link rel="stylesheet" href="/ppe_1/config/pico.css">
  </head>
  <body>
    <main>
      <header>
        <?php require_once __DIR__ . '/partial/header.php'; ?>
      </header>
      
      <section class="section">
        <h3>🏆 Mes inscriptions</h3>
        <p>Retrouvez ici la liste complète de tous les matchs auxquels vous êtes inscrit.</p>
        
        <?php
        if (isset($matchs) && !empty($matchs)) {
            foreach ($matchs as $match) {
        ?>
          <div class="match-card" style="margin-bottom: 1rem;">
            <div class="match-info">
              <span><strong><?php echo htmlspecialchars($match['libéllé'] ?? 'N/A'); ?></strong></span>
              <span>Début: <code><?php echo htmlspecialchars($match['date_debut'] ?? 'N/A'); ?></code></span>
              <span>Fin: <code><?php echo htmlspecialchars($match['date_fin'] ?? 'N/A'); ?></code></span>
            </div>
            <div style="margin-top: 0.5rem;">
              <a href="/ppe_1/public/index.php?page=match_details&id=<?= $match['id_match'] ?>" role="button" class="secondary outline" style="padding: 0.25rem 0.75rem; font-size: 0.875rem;">Voir les détails</a>
              <form method="POST" action="/ppe_1/public/index.php?page=mes_inscriptions" style="display:inline;">
                <input type="hidden" name="action" value="desinscrire">
                <input type="hidden" name="id_match" value="<?php echo $match['id_match']; ?>">
                <button type="submit" class="outline" style="padding: 0.25rem 0.75rem; font-size: 0.875rem; margin-left: 0.5rem; color: #d81b60; border-color: #d81b60;">Se désinscrire</button>
              </form>
            </div>
          </div>
        <?php
            }
        } else {
            echo '<p><em>Vous n\'avez aucune inscription pour le moment.</em></p>';
        }
        ?>
        <div style="margin-top: 1rem;">
          <a href="/ppe_1/public/index.php?page=accueil" role="button" class="secondary outline">Retour à l'accueil</a>
        </div>
      </section>
    </main>
  </body>
</html>
