<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Connexion</title>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@picocss/pico@1/css/pico.min.css">
        <link rel="stylesheet" href="/ppe_1/config/pico.css">
    </head>
    <body class="auth-page-body">
        <main class="container auth-container" style="max-width: 500px;">
            <article>
                <h2>🔑 Connexion</h2>
                
                <?php if (isset($error)): ?>
                    <div class="alert-error">
                        <strong>Erreur : </strong> <?= htmlspecialchars($error) ?>
                    </div>
                <?php endif; ?>

                <form method="POST" action="/ppe_1/public/index.php?page=connexion">
                    <label for="login">Login (Pseudo)
                        <input type="text" id="login" name="login" required>
                    </label>

                    <label for="mdp">Mot de passe
                        <input type="password" id="mdp" name="mdp" required>
                    </label>

                    <button type="submit" style="margin-top: 1rem;">Se connecter</button>
                </form>
                <div class="link-container">
                    <a href="/ppe_1/public/index.php?page=inscription">Pas encore de compte ? Inscrivez-vous ci-dessous</a>
                </div>
            </article>
        </main>
    </body>
</html>