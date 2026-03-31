<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Inscription - Antigravity Sport</title>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@picocss/pico@1/css/pico.min.css">
        <link rel="stylesheet" href="/ppe_1/config/pico.css">
    </head>
    <body class="auth-page-body">
        <main class="container auth-container">
            <article>
                <h2>📝 Créer un compte Joueur</h2>
                
                <?php 
                // Afficher toutes les erreurs en session
                if(isset($_SESSION['errors']) && !empty($_SESSION['errors'])): ?>
                    <div class="alert-error">
                        <strong>Erreur(s) :</strong>
                        <ul style="margin: 0.5rem 0 0 1.5rem;">
                            <?php foreach($_SESSION['errors'] as $error): ?>
                                <li><?= htmlspecialchars($error) ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                    <?php unset($_SESSION['errors']); ?>
                <?php endif; ?>
                
                <form method="POST" action="/ppe_1/public/index.php?page=inscription" style="margin-bottom: 0;">
                    <div class="grid">
                        <label for="Prenom">Prénom
                            <input type="text" id="Prenom" name="Prenom" placeholder="Ex: Jean" required>
                        </label>
                        <label for="Nom">Nom
                            <input type="text" id="Nom" name="Nom" placeholder="Ex: Dupont" required>
                        </label>
                    </div>

                    <div class="grid">
                        <label for="login">Pseudo (Login)
                            <input type="text" id="login" name="login" placeholder="Ex: jdupont75" required>
                        </label>
                        <label for="tel">Téléphone
                            <input type="tel" id="tel" name="tel" placeholder="06..." required>
                        </label>
                    </div>

                    <label for="mail">Email
                        <input type="email" id="mail" name="mail" placeholder="email@exemple.com" required>
                    </label>

                    <fieldset>
                        <legend style="margin-bottom: 0.5rem; font-weight: bold; color: var(--h1-color);">Niveau d'expérience</legend>
                        <div class="grid" style="align-items: center;">
                            <label><input type="radio" name="niv" value="debutant" required> 🌱 Débutant</label>
                            <label><input type="radio" name="niv" value="intermediaire"> ⚡ Intermédiaire</label>
                            <label><input type="radio" name="niv" value="expert"> 🔥 Expert</label>
                        </div>
                    </fieldset>

                    <div class="grid" style="margin-top: 1.5rem;">
                        <label for="Mdp">Mot de passe
                            <input type="password" id="Mdp" name="Mdp" placeholder="8 carac, 1 Maj, 1 chiffre, 1 spé" pattern="(?=.*\d)(?=.*[A-Z])(?=.*[^a-zA-Z\d]).{8,}" title="Le mot de passe doit faire au moins 8 caractères et inclure 1 majuscule, 1 chiffre et 1 caractère spécial." required>
                        </label>
                        <label for="Mdp2">Confirmer le mot de passe
                            <input type="password" id="Mdp2" name="Mdp2" placeholder="Saisir à nouveau..." required>
                        </label>
                    </div>

                    <button type="submit" style="margin-top: 1rem;">S'inscrire maintenant</button>
                </form>
                <div class="link-container">
                    <a href="/ppe_1/public/index.php?page=connexion">Déjà inscrit ? Connectez-vous ici</a>
                </div>
            </article>
        </main>
    </body>
</html>