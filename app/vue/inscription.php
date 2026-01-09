<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <title>Inscription</title>
        <!-- stylesheet removed as requested -->
    </head>
    <body>
        <div class="container">
            <h2>inscription</h2>
            <form method="POST" action="/ppe_1/app/controller/controllerInscription.php">
                <div class="form-group">
                    <label for="Nom">Nom :</label>
                    <input type="text" id="Nom" name="Nom" required>
                </div>

                <div class="form-group">
                    <label for="Prenom">Prénom :</label>
                    <input type="text" id="Prenom" name="Prenom" required>
                </div>

                <div class="form-group">
                    <label for="login">Login :</label>
                    <input type="text" id="login" name="login" required>
                </div>

                <div class="form-group">
                    <label for="tel">Téléphone :</label>
                    <input type="text" id="tel" name="tel" required>
                </div>

                <div class="form-group">
                    <label for="mail">Mail :</label>
                    <input type="text" id="mail" name="mail" required>
                </div>

                <fieldset>
                    <legend>Niveau</legend>
                    <div class="radio-group">
                        <label class="radio-item"><input type="radio" name="niv" value="debutant" required> Débutant</label>
                        <label class="radio-item"><input type="radio" name="niv" value="intermediaire"> Intermédiaire</label>
                        <label class="radio-item"><input type="radio" name="niv" value="expert"> Expert</label>
                    </div>
                </fieldset>


                <div class="form-group">
                    <label for="Mdp">Mot de passe :</label>
                    <input type="password" id="Mdp" name="Mdp" required>
                </div>

                <div class="form-group">
                    <label for="Mdp2">Confirmer le mot de passe :</label>
                    <input type="password" id="Mdp2" name="Mdp2" required>
                </div>

                <button type="submit" class="btn">S'inscrire</button>
            </form>
            <div class="links">
                <a href="../controller/controllerConnexion.php">Déjà inscrit ? Connectez-vous</a>
            </div>
        </div>
    </body>
</html>