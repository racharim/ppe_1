<nav>
    <a class="<?php echo ($page === 'agenda') ? 'active' : ''; ?>" href="/ppe_1/public/index.php?page=agenda">agenda des matchs</a>

    <a class="<?php echo ($page === 'pagesSports') ? 'active' : ''; ?>" href="/ppe_1/public/index.php?page=pagesSports">page de presentation des sports</a>

    <a class="<?php echo ($page === 'accueil') ? 'active' : ''; ?>" href="/ppe_1/public/index.php?page=accueil">page d'accueil</a>

    <a class="<?php echo ($page === 'compte') ? 'active' : ''; ?>" href="/ppe_1/public/index.php?page=compte">mon compte</a>
  
    <?php if (isset($_SESSION['utilisateur']) && $_SESSION['utilisateur']->getTypeCompte() == 3 && $page !== 'compte') : ?>
    <a class="<?php echo ($page === 'compte') ? 'active' : ''; ?>" href="/ppe_1/public/index.php?page=compte">admin</a>
  <?php endif; ?>

    <a class="<?php echo ($page === 'deconnexion') ? 'active' : ''; ?>" href="/ppe_1/public/index.php?page=deconnexion">deconnexion</a>
</nav> 