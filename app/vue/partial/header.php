<?php $current = basename($_SERVER['PHP_SELF']); ?>

<nav>
  <?php if ($current !== 'controllerAgenda.php') : ?><a href="agenda.php">agenda des matchs</a><?php endif; ?>
  <?php if ($current !== 'controllerPagesSports.php') : ?><a href="../controller/controllerPageSports.php">page de presentation des sports</a><?php endif; ?>
  <?php if ($current !== 'controllerAccueil.php') : ?><a href="../controller/controllerAccueil.php">page d'accueil</a><?php endif; ?>
  <?php if ($current !== 'controllerCompte.php') : ?><a href="../controller/controllerCompte.php">mon compte</a><?php endif; ?>
  <?php if ($current !== 'controllerDeconnexion.php') : ?><a href="../controller/controllerDeconnexion.php">deconnexion</a><?php endif; ?>
</nav> 