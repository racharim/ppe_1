<!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des sports</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@picocss/pico@1/css/pico.min.css">
    <link rel="stylesheet" href="/ppe_1/config/pico.css">
  </head>
  <body>
    <main>
      <header>
        <?php require_once __DIR__ . '/partial/header.php'; ?>
      </header>
      <h2>Liste des sports</h2>

      <?php if (!empty($messageSucces)): ?>
        <article style="background-color: #d4edda; color: #155724; border: 1px solid #c3e6cb; padding: 1rem; margin-bottom: 1rem; border-radius: 0.25rem;">
          <?= htmlspecialchars($messageSucces) ?>
        </article>
      <?php endif; ?>

      <?php if (empty($sports)) : ?>  
        <p>Aucun sport trouvé en base de données.</p>
      <?php else : ?>
        <table role="table">
          <thead>
            <tr>
              <th>ID</th>
              <th>Nom</th>
              <th>Description</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($sports as $sport) : ?>
              <tr>
                <td data-label="ID"><?php echo htmlspecialchars($sport['id_sport'] ?? $sport['id'] ?? ''); ?></td>
                <td data-label="Nom"><?php echo htmlspecialchars($sport['nom'] ?? $sport['libelle'] ?? $sport['libéllé'] ?? ''); ?></td>
                <td data-label="Description"><?php echo htmlspecialchars($sport['descriptif'] ?? $sport['description'] ?? ''); ?></td>
                <td data-label="Action">
                  <?php 
                  $sportId = $sport['id_sport'] ?? $sport['id'] ?? 0;
                  $estFavori = in_array($sportId, $mesFavoris ?? []);
                  ?>
                  <form method="POST" action="/ppe_1/public/index.php?page=pagesSports" style="margin: 0;">
                    <input type="hidden" name="id_sport" value="<?= $sportId ?>">
                    <?php if ($estFavori): ?>
                      <input type="hidden" name="action" value="desinscrire">
                      <button type="submit" class="secondary">Se désinscrire</button>
                    <?php else: ?>
                      <input type="hidden" name="action" value="inscrire">
                      <button type="submit">S'inscrire</button>
                    <?php endif; ?>
                  </form>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      <?php endif; ?>
    </main>
  </body>
</html>
