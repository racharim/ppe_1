<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title><?php echo $pageTitle; ?></title>
    <link rel="stylesheet" href="/style.css">
</head>
<body>
    <?php include __DIR__ . '/../../app/vue/partial/header.php'; ?>
    <main>
        <?php echo $content; ?>
    </main>
</body>
</html>