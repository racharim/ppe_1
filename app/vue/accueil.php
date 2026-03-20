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
      
      <?php if(isset($_SESSION['utilisateur']) && $_SESSION['utilisateur']->getTypeCompte() == 1){ ?>
      
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
            <form method="POST" action="/ppe_1/public/index.php?page=accueil" style="display:inline;">
              <input type="hidden" name="action" value="desinscrire">
              <input type="hidden" name="id_match" value="<?php echo $match['id_match']; ?>">
              <button type="submit" class="outline" style="padding: 0.25rem 0.75rem; font-size: 0.875rem;">Se désinscrire</button>
            </form>
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
            <form method="POST" action="/ppe_1/public/index.php?page=accueil" style="display:inline;">
              <input type="hidden" name="action" value="inscrire">
              <input type="hidden" name="id_match" value="<?php echo $matchRec['id_match'] ?? ''; ?>">
              <button type="submit" class="contrast" style="padding: 0.25rem 0.75rem; font-size: 0.875rem;">S'inscrire</button>
            </form>
          </div>
        <?php
            }
        } else {
            echo '<p><em>Aucun match recommandé pour le moment.</em></p>';
        }
        ?>
      </section>

      <?php } elseif(isset($_SESSION['utilisateur']) && $_SESSION['utilisateur']->getTypeCompte() == 2){ ?>
      
      <section class="section">
        <h3>🎯 Les matchs de votre sport</h3>
        <?php
        if (isset($matchsCoach) && !empty($matchsCoach)) {
            foreach ($matchsCoach as $match) {
        ?>
          <div class="event-card" style="margin-bottom: 1rem;">
            <div class="match-info">
              <span><strong><?php echo htmlspecialchars($match['nom_match'] ?? 'N/A'); ?></strong></span>
              <span>Date: <code><?php echo htmlspecialchars($match['date_debut'] ?? 'N/A'); ?></code></span>
              <span>Description: <em><?php echo htmlspecialchars($match['descriptif'] ?? 'N/A'); ?></em></span>
            </div>
          </div>
        <?php
            }
        } else {
            echo '<p><em>Aucun match n\'est prévu pour votre sport pour l\'instant.</em></p>';
        }
        ?>
      </section>

      <?php } elseif(isset($_SESSION['utilisateur']) && $_SESSION['utilisateur']->getTypeCompte() == 3){ ?>
      
      <section class="section">
        <h3>📊 Statistiques de la plateforme</h3>
        <p>Vision d'ensemble de l'intérêt des joueurs pour les différents sports.</p>
        
        <div class="grid">
          <article style="text-align: center;">
            <h4 style="margin-bottom: 0;">Total des Joueurs Inscrits</h4>
            <h1 style="color: var(--primary); font-size: 4rem; margin: 0;"><?= $totalJoueurs ?? 0 ?></h1>
          </article>

          <article>
            <h4 style="margin-bottom: 1rem;">Répartition par sport (Favoris)</h4>
            <?php if (isset($statsSports) && !empty($statsSports)): ?>
              <ul style="list-style: none; padding: 0;">
              <?php foreach ($statsSports as $stat): 
                $nb = $stat['count_joueurs'];
                // On compare aux joueurs totaux inscrits
                $pourcentage = ($totalJoueurs > 0) ? round(($nb / $totalJoueurs) * 100) : 0;
              ?>
                <li style="margin-bottom: 1rem;">
                  <div style="display: flex; justify-content: space-between;">
                    <strong><?= htmlspecialchars($stat['nom']) ?></strong>
                    <span><?= $nb ?> joueur(s) (<?= $pourcentage ?> %)</span>
                  </div>
                  <progress value="<?= $pourcentage ?>" max="100" style="margin-top: 0.25rem; margin-bottom: 0;"></progress>
                </li>
              <?php endforeach; ?>
              </ul>
            <?php else: ?>
              <p><em>Aucune donnée disponible pour le moment.</em></p>
            <?php endif; ?>
          </article>

          <article>
            <h4 style="margin-bottom: 1rem;">Matchs programmés par mois</h4>
            <?php if (isset($matchsParMois) && !empty($matchsParMois)): ?>
              <ul style="list-style: none; padding: 0;">
              <?php foreach ($matchsParMois as $m): 
                // Formatage de YYYY-MM en MM/YYYY pour un affichage plus clair
                $moisStr = date("m/Y", strtotime($m['mois'] . '-01'));
              ?>
                <li style="margin-bottom: 0.5rem; display: flex; justify-content: space-between; border-bottom: 1px solid var(--muted-border-color); padding-bottom: 0.5rem;">
                  <strong><?= htmlspecialchars($moisStr) ?></strong>
                  <span style="font-weight: bold; color: var(--primary);"><?= $m['nb_matchs'] ?> match(s)</span>
                </li>
              <?php endforeach; ?>
              </ul>
            <?php else: ?>
              <p><em>Aucun match planifié.</em></p>
            <?php endif; ?>
          </article>

          <article>
            <h4 style="margin-bottom: 1rem;">Joueurs les plus inactifs</h4>
            <p style="font-size: 0.85rem; color: var(--h1-color); margin-top: -0.5rem;">(Top 5 des dernières connexions les plus anciennes)</p>
            <?php if (isset($oldestPlayers) && !empty($oldestPlayers)): ?>
              <ul style="list-style: none; padding: 0;">
              <?php foreach ($oldestPlayers as $player): 
                $dateConnexion = date('d/m/Y à H:i', strtotime($player['derniere_connexion']));
              ?>
                <li style="margin-bottom: 0.5rem; display: flex; justify-content: space-between; border-bottom: 1px solid var(--muted-border-color); padding-bottom: 0.5rem;">
                  <strong><?= htmlspecialchars($player['prenom'] . ' ' . $player['nom']) ?></strong>
                  <span align="right" style="color: var(--secondary); font-size: 0.9rem;"><?= $dateConnexion ?></span>
                </li>
              <?php endforeach; ?>
              </ul>
            <?php else: ?>
              <p><em>Aucune donnée de connexion disponible.</em></p>
            <?php endif; ?>
          </article>
        </div>
      </section>

      <?php } ?>
    </main>
  </body>
</html>