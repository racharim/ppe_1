<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <title>Connexion</title>
    </head>
    <body>
        <div>
            <h2>Connexion</h2>
            <form method="POST" action="/ppe_1/app/controller/controllerConnexion">

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
                <a href="../controller/controllerInscription.php">Pas encore de compte ? Inscrivez-vous</a>
            </div>
        </div>
    </body>
</html>