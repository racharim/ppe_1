<!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="UTF-8">
    <title>Accueil</title>
    <link rel="stylesheet" href="../../config/style.css">
  </head>
  <body>
    <main>
      <header>
        <div>
          <h1>site d'inscription de la M2L</h1>
          <nav class="links">
            <a href="#agenda">agenda des matchs</a>
            <a href="#sports">page de presentation des sports</a>
            <a href="accueil.php">page d'accueil</a>
            <a href="#compte">mon compte</a>
          </nav>
        </div>
      </header>

      <?php require_once 'C:/wamp64/www/ppe_1/app/controller/controllerAccueil'; ?>
      <section>
        <div >
          <h3>vos inscription :</h3>
          <div><?php 
            if (isset($matchs) && !empty($matchs)) {
              foreach($matchs as $match) { 
          ?>
            <div>
              <span>  Date: <?php echo $match['date']; ?></span>
              <span> | Sport: <?php echo $match['sport']; ?></span>
            </div>
            <?php 
              }
            } else {
              echo '<p>Aucun match pour vous.</p>';
            }
          ?>
          </div>
        </div>

        <div>
          <h3>pour vous :</h3>
          <div>resumer des match qui pourrait vous interesser</div>
        </div>
      </section>
    </main>
  </body>
</html>