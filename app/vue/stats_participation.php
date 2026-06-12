<!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Statistiques de participation</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@picocss/pico@1/css/pico.min.css">
    <link rel="stylesheet" href="/config/pico.css">
  </head>
  <body>
    <main>
      <header>
        <?php require_once __DIR__ . '/partial/header.php'; ?>
      </header>

      <h2>Statistiques de participation par sport</h2>
      <p>Nombre de joueurs distincts inscrits a au moins un match du sport.</p>

      <?php if (empty($statsParticipation)) : ?>
        <p>Aucune statistique disponible.</p>
      <?php else : ?>
        <table role="table">
          <thead>
            <tr>
              <th>Sport</th>
              <th>Nombre de participants</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($statsParticipation as $stat) : ?>
              <tr>
                <td><?= htmlspecialchars($stat['nom'] ?? 'N/A') ?></td>
                <td><?= (int)($stat['nb_participants'] ?? 0) ?></td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      <?php endif; ?>
    </main>
  </body>
</html>
