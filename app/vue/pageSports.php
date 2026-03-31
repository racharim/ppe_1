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
        <article class="alert-success">
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
              <?php if (isset($_SESSION['utilisateur']) && $_SESSION['utilisateur']->getTypeCompte() == 1): ?>
                <th>Action</th>
              <?php endif; ?>
              <?php if (isset($_SESSION['utilisateur']) && $_SESSION['utilisateur']->getTypeCompte() == 3): ?>
                <th>Administration</th>
              <?php endif; ?>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($sports as $sport) : ?>
              <tr>
                <td data-label="ID"><?php echo htmlspecialchars($sport['id_sport'] ?? $sport['id'] ?? ''); ?></td>
                <td data-label="Nom"><?php echo htmlspecialchars($sport['nom'] ?? $sport['libelle'] ?? $sport['libéllé'] ?? ''); ?></td>
                <td data-label="Description"><?php echo htmlspecialchars($sport['descriptif'] ?? $sport['description'] ?? ''); ?></td>
                <?php if (isset($_SESSION['utilisateur']) && $_SESSION['utilisateur']->getTypeCompte() == 1): ?>
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
                <?php endif; ?>
                <?php if (isset($_SESSION['utilisateur']) && $_SESSION['utilisateur']->getTypeCompte() == 3): ?>
                <td data-label="Administration">
                  <?php $sportId = $sport['id_sport'] ?? $sport['id'] ?? 0; ?>
                  <form method="POST" action="/ppe_1/public/index.php?page=pagesSports" style="margin: 0;">
                    <input type="hidden" name="id_sport" value="<?= $sportId ?>">
                    <input type="hidden" name="action" value="delete_sport">
                    <button type="submit" style="background-color: #d81b60; border-color: #d81b60;" onclick="return confirm('Êtes-vous sûr de vouloir supprimer définitivement ce sport ? (Ceci effacera aussi les données liées : matchs, coachs affectés, etc.)');">Supprimer</button>
                  </form>
                </td>
                <?php endif; ?>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      <?php endif; ?>
    </main>
  </body>
</html>
