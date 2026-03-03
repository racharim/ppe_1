<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Connexion</title>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@picocss/pico@1/css/pico.min.css">
        <link rel="stylesheet" href="/ppe_1/config/pico.css">
    </head>
    <body>
        <div>
            <h2>Connexion</h2>
            <form method="POST" action="/ppe_1/public/index.php?page=connexion">

                <div>
                    <label for="login">Login :</label>
                    <input type="text" id="login" name="login" required>
                </div>

                <div>
                    <label for="mdp">Mot de passe :</label>
                    <input type="password" id="mdp" name="mdp" required>
                </div>

                <button type="submit">Se connecter</button>
            </form>
            <div>
                <a href="/ppe_1/public/index.php?page=inscription">Pas encore de compte ? Inscrivez-vous</a>
            </div>
        </div>
    </body>
</html>