<!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="UTF-8">
    <title>Liste des sports</title>
    <link rel="stylesheet" href="../../config/style.css">
  </head>
  <body>
    <main class="container">
      <h2>Liste des sports</h2>
      <?php require_once 'C:/wamp64/www/ppe_1/app/controller/controllerPageSports.php'; ?>

      <?php if (empty($sports)) : ?>  
        <p>Aucun sport trouvé en base de données.</p>
      <?php else : ?>
        <table class="my-table" role="table">
          <thead>
            <tr>
              <th>ID</th>
              <th>Nom</th>
              <th>Description</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($sports as $sport) : ?>
              <tr>
                <td data-label="ID"><?php echo htmlspecialchars($sport['id_sport'] ?? $sport['id'] ?? ''); ?></td>
                <td data-label="Nom"><?php echo htmlspecialchars($sport['nom'] ?? $sport['libelle'] ?? $sport['libéllé'] ?? ''); ?></td>
                <td data-label="Description"><?php echo htmlspecialchars($sport['descriptif'] ?? $sport['description'] ?? ''); ?></td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      <?php endif; ?>

      <div class="links">
        <a href="accueil.php">Retour à l'accueil</a>
      </div>
    </main>
  </body>
</html>
