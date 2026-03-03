<!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon compte</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@picocss/pico@1/css/pico.min.css">
    <link rel="stylesheet" href="/ppe_1/config/pico.css">
    <script src="/ppe_1/config/tabs.js"></script>
  </head>
  <body>
    <main>
      <header>
        <?php require_once __DIR__ . '/partial/header.php'; ?>
      </header>
        <?php if($_SESSION['utilisateur_type'] == 1){ ?>
        <div>
          <h2>Mon Compte</h2>
          <p>Bienvenue sur votre page de compte. Ici, vous pouvez gérer vos informations personnelles et vos préférences.</p>
        </div>
        <h3>Informations personnelles :</h3>
        <div>
          <form method="POST" action="/ppe_1/public/index.php?page=compte">
            <label for="nom">Nom : </label>
              <input type="text" id="nom" name="nom" value="<?php echo $_SESSION['joueur']->getNom(); ?>" required><br><br>
            <label for="prenom">Prenom : </label>
              <input type="text" id="prenom" name="prenom" value="<?php echo $_SESSION['joueur']->getPrenom(); ?>" required><br><br>
            <label for="prenom">Téléphone : </label>
              <input type="text" id="tel" name="tel" value="<?php echo $_SESSION['joueur']->getTel(); ?>" required><br><br>
            <label for="prenom">Mail : </label>
              <input type="text" id="mail" name="mail" value="<?php echo $_SESSION['joueur']->getMail(); ?>" required><br><br>
            <button type="submit">Modifier</button>
          </form>
        </div>
        <div>
          <h3>Vos inscriptions :</h3>
          <div>
            <?php
              if (isset($matchs) && !empty($matchs)) {
                  foreach ($matchs as $match) { ?>
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
            
          <div>
            <h3>Vos sports favoris</h3>
            <?php
              if (isset($sportsFavoris) && !empty($sportsFavoris)) {
                  foreach ($sportsFavoris as $sport) { ?>
                <p>
                  <span>Sport: <?php echo $sport['nom'] ?? 'N/A'; ?></span>
                </p>
            <?php
                }
              }
            ?>
            <div>
              <form method="POST" action="/ppe_1/public/index.php?page=compte">
                <label for="sport">Ajouter un sport favori :</label>
                <select id="sport" name="sport">
                  <?php
                    if(isset($listeSport) && !empty($listeSport)) {
                      foreach ($listeSport as $sport) {
                  ?>
                  <option value="<?php echo $sport['id_sport'] ?? ''; ?>"><?php echo $sport['nom'] ?? 'N/A'; ?></option>
                  <?php 
                      } 
                    }
                  ?>
                </select>
                <button type="submit">Ajouter</button>
              </form>
            </div>
          </div>
        </div>
        <?php } elseif($_SESSION['utilisateur_type'] == 3){ ?>
          <h2>🔧 Administration</h2>
          <p>Gérez les utilisateurs, les sports et les matchs.</p>

          <!-- Système d'onglets -->
          <div class="tabs">
            <button class="tab-button active" data-tab="utilisateurs">👥 Utilisateurs</button>
            <button class="tab-button" data-tab="sports">⚽ Sports</button>
            <button class="tab-button" data-tab="matchs">🏆 Matchs</button>
          </div>

          <!-- Onglet Utilisateurs -->
          <div id="utilisateurs" class="tab-content active">
            <div class="admin-section">
              <h3>Gérer les utilisateurs</h3>
              <p>Les utilisateurs seront affichés ici.</p>
              <!-- TODO: liste des utilisateurs avec actions -->
            </div>
          </div>

          <!-- Onglet Sports -->
          <div id="sports" class="tab-content">
            <div class="admin-section">
              <h3>Gérer les sports</h3>
              <p>Les sports seront affichés ici.</p>
              <!-- TODO: liste des sports avec actions -->
            </div>
          </div>

          <!-- Onglet Matchs -->
          <div id="matchs" class="tab-content">
            <div class="admin-section">
              <h3>Gérer les matchs</h3>
              <p>Les matchs seront affichés ici.</p>
              <!-- TODO: liste des matchs avec actions -->
            </div>
          </div>
        <?php } ?>
    </main>
  </body>
</html>