<!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="UTF-8">
    <title>Mon compte</title>
  </head>
  <body>
    <main>
      <header>
        <?php require_once 'C:/wamp64/www/ppe_1/app/vue/partial/header.php'; ?>
      </header>
        <div>
          <h2>Mon Compte</h2>
          <p>Bienvenue sur votre page de compte. Ici, vous pouvez gérer vos informations personnelles et vos préférences.</p>
        </div>
        <h3>Informations personnelles :</h3>
        <div>
          <form method="POST" action="/ppe_1/app/controller/controllerCompte">
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
              <form method="POST" action="/ppe_1/app/controller/controllerCompte">>
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
    </main>
  </body>
</html>