<!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="UTF-8">
    <title>Accueil</title>
    <link rel="stylesheet" href="../../config/style.css">
  </head>
  <body>
    <main>
      <header>
        <div>
          <h1>site d'inscription de la M2L</h1>
          <nav class="links">
            <a href="#agenda">agenda des matchs</a>
            <a href="#sports">page de presentation des sports</a>
            <a href="accueil.php">page d'accueil</a>
            <a href="#compte">mon compte</a>
          </nav>
        </div>
      </header>

      <?php require_once 'C:/wamp64/www/ppe_1/app/controller/controllerAccueil.php'; ?>
      <section>
        <div>
          <h3>Vos inscriptions :</h3>
          <div><?php 
            if (isset($matchs) && !empty($matchs)) {
              foreach($matchs as $match) { 
            ?>
            <div>
              <span>Date début: <?php echo $match['date_debut'] ?? 'N/A'; ?></span>
              <span> | Date fin: <?php echo $match['date_fin'] ?? 'N/A'; ?></span>
              <span> | Sport: <?php echo $match['libéllé'] ?? 'N/A'; ?></span>
            </div>
            <?php 
              }
            } else {
              echo '<p>Aucun match pour vous.</p>';
            }
            ?>
          </div>
        </div>
        <div>
          <h3>Pour vous (Matchs recommandés) :</h3>
          <div><?php
            if (isset($matchsRecommandes) && !empty($matchsRecommandes)) {
              foreach($matchsRecommandes as $matchRec) {
            ?>
            <div>
              <span>Match: <?php echo $matchRec['nom_match'] ?? 'N/A'; ?></span>
              <span> | Date: <?php echo $matchRec['date_debut'] ?? 'N/A'; ?></span>
              <span> | Description: <?php echo $matchRec['descriptif'] ?? 'N/A'; ?></span>
            </div>
            <?php
              }
            } else {
              echo '<p>Aucun match recommandé pour vous.</p>';
            }
          ?>
          </div>
        </div>
      </section>
    </main>
  </body>
</html>