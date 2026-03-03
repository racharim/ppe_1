<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Inscription</title>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@picocss/pico@1/css/pico.min.css">
        <link rel="stylesheet" href="/ppe_1/config/pico.css">
    </head>
    <body>
        <div>
            <h2>inscription</h2>
            <form method="POST" action="/ppe_1/public/index.php?page=inscription">
                <div>
                    <label for="Nom">Nom :</label>
                    <input type="text" id="Nom" name="Nom" required>
                </div>

                <div>
                    <label for="Prenom">Prénom :</label>
                    <input type="text" id="Prenom" name="Prenom" required>
                </div>

                <div>
                    <label for="login">Login :</label>
                    <input type="text" id="login" name="login" required>
                </div>

                <div>
                    <label for="tel">Téléphone :</label>
                    <input type="text" id="tel" name="tel" required>
                </div>

                <div>
                    <label for="mail">Mail :</label>
                    <input type="text" id="mail" name="mail" required>
                </div>

                <fieldset>
                    <legend>Niveau</legend>
                    <div>
                        <label><input type="radio" name="niv" value="debutant" required> Débutant</label>
                        <label><input type="radio" name="niv" value="intermediaire"> Intermédiaire</label>
                        <label><input type="radio" name="niv" value="expert"> Expert</label>
                    </div>
                </fieldset>


                <div>
                    <label for="Mdp">Mot de passe :</label>
                    <input type="password" id="Mdp" name="Mdp" required>
                </div>

                <div>
                    <label for="Mdp2">Confirmer le mot de passe :</label>
                    <input type="password" id="Mdp2" name="Mdp2" required>
                </div>

                <button type="submit">S'inscrire</button>
            </form>
            <div>
                <a href="/ppe_1/public/index.php?page=connexion">Déjà inscrit ? Connectez-vous</a>
            </div>
        </div>
    </body>
</html>