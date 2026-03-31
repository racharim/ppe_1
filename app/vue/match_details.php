<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détails du Match - <?= htmlspecialchars($matchDetails['libéllé'] ?? $matchDetails['nom_match'] ?? 'Match') ?></title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@picocss/pico@1/css/pico.min.css">
    <link rel="stylesheet" href="/ppe_1/config/pico.css">
</head>
<body>
    <main class="container">
        <header>
            <?php require_once __DIR__ . '/partial/header.php'; ?>
        </header>

        <section class="section">
            <h2>Détails du Match</h2>
            
            <?php if (isset($_GET['success']) && $_GET['success'] == 1): ?>
                <div class="match-success-alert">
                    ✅ Le match a été modifié avec succès.
                </div>
            <?php endif; ?>
            
            <article>
                <header>
                    <h3 class="match-title">🏆 <?= htmlspecialchars($matchDetails['libéllé'] ?? $matchDetails['nom_match'] ?? 'Match sans nom') ?></h3>
                    <p class="match-sport-name"><?= htmlspecialchars($matchDetails['nom_sport']) ?></p>
                </header>
                
                <div class="grid">
                    <div>
                        <strong><span aria-hidden="true">📅</span> Début :</strong>
                        <p><?= htmlspecialchars($dateDebut) ?></p>
                        
                        <strong><span aria-hidden="true">⏳</span> Fin :</strong>
                        <p><?= htmlspecialchars($dateFin) ?></p>
                    </div>
                    <div>
                        <strong><span aria-hidden="true">📍</span> Lieu :</strong>
                        <p><?= htmlspecialchars($matchDetails['n_rue'] . ' ' . $matchDetails['rue']) ?><br>
                           <?= htmlspecialchars($matchDetails['code_postal']) ?></p>
                        
                        <strong><span aria-hidden="true">📈</span> Niveau requis :</strong>
                        <p><?= htmlspecialchars($matchDetails['niveau']) ?></p>
                    </div>
                </div>

                <div class="match-description-container">
                    <strong><span aria-hidden="true">📝</span> Description :</strong>
                    <blockquote class="match-description-quote">
                        <?= nl2br(htmlspecialchars($matchDetails['descriptif'] ?: 'Aucune description fournie.')) ?>
                    </blockquote>
                </div>
                
                <footer class="match-details-footer">
                    <a href="/ppe_1/public/index.php?page=accueil" role="button" class="secondary">🔙 Retour au tableau de bord</a>
                    <?php if (isset($_SESSION['utilisateur']) && in_array((int)$_SESSION['utilisateur']->getTypeCompte(), [2, 3])): ?>
                        <a href="#edit" role="button" data-target="edit-modal" onClick="toggleModal(event)" class="btn-no-margin">✏️ Modifier le match</a>
                    <?php endif; ?>
                </footer>
            </article>
        </section>
    </main>

    <?php if (isset($_SESSION['utilisateur']) && in_array((int)$_SESSION['utilisateur']->getTypeCompte(), [2, 3])): ?>
    <dialog id="edit-modal">
      <article>
        <header>
            <a href="#close" aria-label="Close" class="close" data-target="edit-modal" onClick="toggleModal(event)"></a>
            Modifier le match
        </header>
        <form method="POST" action="/ppe_1/public/index.php?page=match_details&id=<?= $matchDetails['id_match'] ?>">
            <input type="hidden" name="action" value="edit_match">
            <input type="hidden" name="id_match" value="<?= $matchDetails['id_match'] ?>">
            
            <label>
                Nom du match
                <input type="text" name="libelle" value="<?= htmlspecialchars($matchDetails['libéllé'] ?? $matchDetails['nom_match'] ?? '') ?>" required>
            </label>
            
            <div class="grid">
                <label>
                    Date de début
                    <input type="datetime-local" name="date_debut" value="<?= date('Y-m-d\TH:i', strtotime($matchDetails['date_debut'])) ?>" required>
                </label>
                
                <label>
                    Date de fin
                    <input type="datetime-local" name="date_fin" value="<?= date('Y-m-d\TH:i', strtotime($matchDetails['date_fin'])) ?>" required>
                </label>
            </div>
            
            <label>
                Descriptif
                <textarea name="descriptif" rows="4" required><?= htmlspecialchars($matchDetails['descriptif'] ?? '') ?></textarea>
            </label>
            
            <footer class="match-modal-footer">
                <a href="#cancel" role="button" class="secondary btn-no-margin" data-target="edit-modal" onClick="toggleModal(event)">Annuler</a>
                <button type="submit" class="btn-no-margin">Enregistrer les modifications</button>
            </footer>
        </form>
      </article>
    </dialog>
    <script>
    function toggleModal(event) {
        event.preventDefault();
        const modal = document.getElementById(event.currentTarget.getAttribute('data-target'));
        if (modal.hasAttribute('open')) {
            modal.removeAttribute('open');
            document.documentElement.classList.remove('modal-is-open', 'modal-is-opening');
        } else {
            modal.setAttribute('open', '');
            document.documentElement.classList.add('modal-is-open', 'modal-is-opening');
        }
    }
    </script>
    <?php endif; ?>
</body>
</html>
