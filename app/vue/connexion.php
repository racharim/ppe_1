<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <title>Connexion</title>
    </head>
    <body>
        <div class="container">
            <h2>Connexion</h2>
            <form method="POST" action="/ppe_1/app/controller/controllerConnexion">

                <div class="form-group">
                    <label for="login">Login :</label>
                    <input type="text" id="login" name="login" required>
                </div>

                <div class="form-group">
                    <label for="mdp">Mot de passe :</label>
                    <input type="password" id="mdp" name="mdp" required>
                </div>

                <button type="submit" class="btn">Se connecter</button>
            </form>
            <div class="links">
                <a href="../controller/controllerInscription.php">Pas encore de compte ? Inscrivez-vous</a>
            </div>
        </div>
    </body>
</html>