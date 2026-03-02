<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <title>Inscription</title>
    </head>
    <body>
        <div>
            <h2>inscription</h2>
            <form method="POST" action="/ppe_1/app/controller/controllerInscription.php">
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
                <a href="../controller/controllerConnexion.php">Déjà inscrit ? Connectez-vous</a>
            </div>
        </div>
    </body>
</html>