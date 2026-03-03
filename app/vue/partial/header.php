<?php
// la variable page provient du front controller
$page = $_GET['page'] ?? 'accueil';
?>

<nav>
  <?php if ($page !== 'agenda') : ?>
    <a href="/ppe_1/public/index.php?page=agenda">agenda des matchs</a>
  <?php endif; ?>

  <?php if ($page !== 'pagesSports') : ?>
    <a href="/ppe_1/public/index.php?page=pagesSports">page de presentation des sports</a>
  <?php endif; ?>

  <?php if ($page !== 'accueil') : ?>
    <a href="/ppe_1/public/index.php?page=accueil">page d'accueil</a>
  <?php endif; ?>

  <?php if ($_SESSION['utilisateur_type'] != 3 && $page !== 'compte') : ?>
    <a href="/ppe_1/public/index.php?page=compte">mon compte</a>
  <?php elseif ($_SESSION['utilisateur_type'] == 3 && $page !== 'compte') : ?>
    <a href="/ppe_1/public/index.php?page=compte">admin</a>
  <?php endif; ?>

  <?php if ($page !== 'deconnexion') : ?>
    <a href="/ppe_1/public/index.php?page=deconnexion">deconnexion</a>
  <?php endif; ?>
</nav> 