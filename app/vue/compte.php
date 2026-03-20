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
        <?php if(isset($_SESSION['utilisateur']) && $_SESSION['utilisateur']->getTypeCompte() == 1){ ?>
        <div>
          <h2>Mon Compte</h2>
          <p>Bienvenue sur votre page de compte. Ici, vous pouvez gérer vos informations personnelles et vos préférences.</p>
        </div>
        <h3>Informations personnelles :</h3>
        <div>
          <form method="POST" action="/ppe_1/public/index.php?page=compte">
            <input type="hidden" name="action" value="update_profil">
            <label for="nom">Nom : </label>
              <input type="text" id="nom" name="nom" value="<?php echo $_SESSION['utilisateur']->getNom(); ?>" required><br><br>
            <label for="prenom">Prenom : </label>
              <input type="text" id="prenom" name="prenom" value="<?php echo $_SESSION['utilisateur']->getPrenom(); ?>" required><br><br>
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
              <?php if(!empty($messageSucces)) { ?><p style="color: green;"><?php echo $messageSucces; ?></p><?php } ?>
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
                <button type="submit">Modifier</button>
              </form>
            </div>
          </div>
        </div>
        <?php } elseif(isset($_SESSION['utilisateur']) && $_SESSION['utilisateur']->getTypeCompte() == 2){ ?>
          <h2>🏋️ Espace Coach</h2>
          <p>Gérez votre profil et organisez des matchs pour votre catégorie : <strong><?= isset($nomSportCoach) ? htmlspecialchars($nomSportCoach) : 'Non défini' ?></strong>.</p>
          
          <?php if(!empty($messageSucces)) { ?><p style="color: green; font-weight: bold;"><?= htmlspecialchars($messageSucces) ?></p><?php } ?>

          <div class="tabs">
            <button class="tab-button active" data-tab="profil_coach">👤 Mon Profil</button>
            <button class="tab-button" data-tab="matchs_coach">🏆 Créer un Match</button>
          </div>

          <!-- Onglet Profil Coach -->
          <div id="profil_coach" class="tab-content active">
            <div class="admin-section">
              <h3>Modifier mes informations</h3>
              <form method="POST" action="/ppe_1/public/index.php?page=compte">
                <input type="hidden" name="action" value="update_profil_coach">
                <label for="nom">Nom : </label>
                <input type="text" id="nom" name="nom" value="<?= htmlspecialchars($_SESSION['utilisateur']->getNom()); ?>" required><br>
                <label for="prenom">Prenom : </label>
                <input type="text" id="prenom" name="prenom" value="<?= htmlspecialchars($_SESSION['utilisateur']->getPrenom()); ?>" required><br><br>
                <button type="submit">Enregistrer les modifications</button>
              </form>
            </div>
          </div>

          <!-- Onglet Matchs Coach -->
          <div id="matchs_coach" class="tab-content">
            <div class="admin-section">
              <h3>Créer un nouveau Match (<?= htmlspecialchars($nomSportCoach ?? 'votre sport') ?>)</h3>
              <form method="POST" action="/ppe_1/public/index.php?page=compte">
                <input type="hidden" name="action" value="add_match_coach">
                
                <label for="libelle">Nom de l'événement</label>
                <input type="text" id="libelle" name="libelle" placeholder="Ex: Entraînement intensif" required>

                <div class="grid">
                  <label for="date_debut">Date & Heure de début
                    <input type="datetime-local" id="date_debut" name="date_debut" required>
                  </label>
                  <label for="date_fin">Date & Heure de fin
                    <input type="datetime-local" id="date_fin" name="date_fin" required>
                  </label>
                </div>

                <div class="grid">
                  <label for="id_niv">Niveau requis
                    <select id="id_niv" name="id_niv" required>
                      <option value="1">Débutant</option>
                      <option value="2">Intermédiaire</option>
                      <option value="3">Avancé</option>
                    </select>
                  </label>

                  <label for="id_lieu">Lieu du match
                    <select id="id_lieu" name="id_lieu" required>
                      <?php foreach ($listeLieu as $lieu): ?>
                        <option value="<?= $lieu['id_lieu'] ?>"><?= htmlspecialchars($lieu['rue'] . ' - ' . $lieu['code_postal']) ?></option>
                      <?php endforeach; ?>
                    </select>
                  </label>
                </div>

                <label for="desc_match">Description</label>
                <textarea id="desc_match" name="descriptif" rows="2" style="resize: none;"></textarea>

                <button type="submit">Publier le match</button>
              </form>
            </div>
          </div>

        <?php } elseif(isset($_SESSION['utilisateur']) && $_SESSION['utilisateur']->getTypeCompte() == 3){ ?>
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
            <h3>👤 Créer un nouveau Joueur</h3>
            
            <form method="POST" action="/ppe_1/public/index.php?page=compte">
              <input type="hidden" name="action" value="add_joueur">
              
              <div class="grid">
                <label>Identifiant (Login)
                  <input type="text" name="login" placeholder="Pseudo" required>
                </label>
                <label>Mot de passe
                  <input type="password" name="mdp" placeholder="****" required>
                </label>
              </div>

              <div class="grid">
                <label>Nom
                  <input type="text" name="nom" required>
                </label>
                <label>Prénom
                  <input type="text" name="prenom" required>
                </label>
              </div>

              <div class="grid">
                <label>Email
                  <input type="email" name="mail" required>
                </label>
                <label>Téléphone
                  <input type="tel" name="tel">
                </label>
              </div>

              <label for="id_niv">Niveau</label>
              <select name="id_niv" id="id_niv" required>
                <option value="1">Débutant</option>
                <option value="2">Intermédiaire</option>
                <option value="3">Expert</option>
              </select>

              <button type="submit">Créer le compte joueur</button>
            </form>
          </div>
          
          <div class="admin-section" style="margin-top: 2rem;">
            <h3>⚽ Créer un nouveau Coach</h3>
            
            <form method="POST" action="/ppe_1/public/index.php?page=compte">
              <input type="hidden" name="action" value="add_coach">
              
              <div class="grid">
                <label>Identifiant (Login)
                  <input type="text" name="login" placeholder="Pseudo" required>
                </label>
                <label>Mot de passe
                  <input type="password" name="mdp" placeholder="****" required>
                </label>
              </div>

              <div class="grid">
                <label>Nom
                  <input type="text" name="nom" required>
                </label>
                <label>Prénom
                  <input type="text" name="prenom" required>
                </label>
              </div>

              <label for="id_sport">Sport enseigné</label>
              <select name="id_sport" id="id_sport" required>
                <?php foreach ($listeSport as $sport): ?>
                  <option value="<?= $sport['id_sport'] ?>"><?= $sport['nom'] ?></option>
                <?php endforeach; ?>
              </select>

              <button type="submit">Créer le compte coach</button>
            </form>
          </div>

          <div class="admin-section" style="margin-top: 2rem; border-color: #3949ab;">
            <h3 style="color: #3949ab;">👑 Créer un nouvel Admin</h3>
            <form method="POST" action="/ppe_1/public/index.php?page=compte">
              <input type="hidden" name="action" value="add_admin">
              
              <div class="grid">
                <label>Identifiant (Login)
                  <input type="text" name="login" placeholder="Pseudo admin" required>
                </label>
                <label>Mot de passe
                  <input type="password" name="mdp" placeholder="****" required>
                </label>
              </div>

              <div class="grid">
                <label>Nom
                  <input type="text" name="nom" required>
                </label>
                <label>Prénom
                  <input type="text" name="prenom" required>
                </label>
              </div>

              <button type="submit" style="background-color: #3949ab; border-color: #3949ab;">Créer le compte administrateur</button>
            </form>
          </div>
          
          <div class="admin-section" style="margin-top: 2rem; border-color: #d81b60;">
            <h3 style="color: #d81b60;">🗑️ Supprimer un Joueur</h3>
            <form method="POST" action="/ppe_1/public/index.php?page=compte">
              <input type="hidden" name="action" value="delete_joueur">
              <label for="delete_id_joueur">Sélectionner le joueur</label>
              <select name="id_utilisateur" id="delete_id_joueur" required>
                <?php if (isset($tousLesJoueurs) && !empty($tousLesJoueurs)): ?>
                  <?php foreach ($tousLesJoueurs as $j): ?>
                    <option value="<?= $j['id_utilisateur'] ?>"><?= htmlspecialchars($j['nom'] . ' ' . $j['prenom'] . ' (' . $j['nom_util'] . ')') ?></option>
                  <?php endforeach; ?>
                <?php else: ?>
                  <option value="" disabled>Aucun joueur existant</option>
                <?php endif; ?>
              </select>
              <button type="submit" style="background-color: #d81b60; border-color: #d81b60;" onclick="return confirm('Êtes-vous sûr de vouloir supprimer définitivement ce joueur ?');">Supprimer ce joueur</button>
            </form>
          </div>

          <div class="admin-section" style="margin-top: 2rem; border-color: #d81b60;">
            <h3 style="color: #d81b60;">🗑️ Supprimer un Coach</h3>
            <form method="POST" action="/ppe_1/public/index.php?page=compte">
              <input type="hidden" name="action" value="delete_coach">
              <label for="delete_id_coach">Sélectionner le coach</label>
              <select name="id_utilisateur" id="delete_id_coach" required>
                <?php if (isset($tousLesCoachs) && !empty($tousLesCoachs)): ?>
                  <?php foreach ($tousLesCoachs as $c): ?>
                    <option value="<?= $c['id_utilisateur'] ?>"><?= htmlspecialchars($c['nom'] . ' ' . $c['prenom'] . ' (' . $c['nom_util'] . ')') ?></option>
                  <?php endforeach; ?>
                <?php else: ?>
                  <option value="" disabled>Aucun coach existant</option>
                <?php endif; ?>
              </select>
              <button type="submit" style="background-color: #d81b60; border-color: #d81b60;" onclick="return confirm('Êtes-vous sûr de vouloir supprimer définitivement ce coach ?');">Supprimer ce coach</button>
            </form>
          </div>
        </div>

          <!-- Onglet Sports -->
          <div id="sports" class="tab-content">
            <div class="admin-section">
              <h3>⚽ Ajouter un nouveau sport</h3>
              
              <form method="POST" action="/ppe_1/public/index.php?page=compte">
                <input type="hidden" name="action" value="add_sport">
                
                <div class="grid">
                  <label for="nom_sport">
                    Nom du sport
                    <input type="text" id="nom_sport" name="nom_sport" placeholder="Ex: Handball" required>
                  </label>
                  
                  <label for="n_joueur">
                    Nombre de joueurs
                    <input type="number" id="n_joueur" name="n_joueur" placeholder="12" required>
                  </label>
                </div>

                <label for="descriptif">Description</label>
                <textarea id="descriptif" name="descriptif" style="resize: none;" placeholder="Décrivez brièvement le sport..." rows="3"></textarea>
                
                <button type="submit" class="contrast">Créer le sport</button>
              </form>
            </div>
          </div>

          <!-- Onglet Matchs -->
          <div id="matchs" class="tab-content">
            <div class="admin-section">
              <h3>🏆 Créer un nouveau Match</h3>
              <form method="POST" action="/ppe_1/public/index.php?page=compte">
                <input type="hidden" name="action" value="add_match">
                
                <label for="libelle">Nom du match</label>
                <input type="text" id="libelle" name="libelle" placeholder="Ex: Tournoi d'été" required>

                <div class="grid">
                  <label for="date_debut">Date & Heure de début
                    <input type="datetime-local" id="date_debut" name="date_debut" required>
                  </label>
                  <label for="date_fin">Date & Heure de fin
                    <input type="datetime-local" id="date_fin" name="date_fin" required>
                  </label>
                </div>

                <div class="grid">
                  <label for="id_sport">Sport concerné
                    <select id="id_sport" name="id_sport" required>
                      <?php foreach ($listeSport as $sport): ?>
                        <option value="<?= $sport['id_sport'] ?>"><?= $sport['nom'] ?></option>
                      <?php endforeach; ?>
                    </select>
                  </label>

                  <label for="id_niv">Niveau requis
                    <select id="id_niv" name="id_niv" required>
                      <option value="1">Débutant</option>
                      <option value="2">Intermédiaire</option>
                      <option value="3">Avancé</option>
                    </select>
                  </label>
                </div>

                <label for="id_lieu">Lieu du match
                  <select id="id_lieu" name="id_lieu" required>
                    <?php foreach ($listeLieu as $lieu): ?>
                      <option value="<?= $lieu['id_lieu'] ?>"><?= $lieu['rue'] . ' - ' . $lieu['code_postal'] ?></option>
                    <?php endforeach; ?>
                  </select>
                </label>

                <label for="desc_match">Description</label>
                <textarea id="desc_match" name="descriptif" rows="2" style="resize: none;"></textarea>

                <button type="submit">Publier le match</button>
              </form>
            </div>
          </div>
        <?php } ?>
    </main>
  </body>
</html>