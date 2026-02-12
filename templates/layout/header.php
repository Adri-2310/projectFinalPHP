<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <!-- Balise meta pour adapter l'affichage sur les écrans mobiles -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Description de la page, définie dans chaque fichier PHP avant l'inclusion du header -->
    <meta name="description" content="<?=$metaDescription?>">
    <title><?=$pageTitre?></title>
    <link rel="stylesheet" href="/public/assets/css/style.css?v=<?php echo time(); ?>">
</head>
<body>
<header>
    <nav>
        <ul>
            <li><a href="/public/index.php" <?= basename($_SERVER['PHP_SELF']) == 'index.php' ? 'class="active"' : '' ?>>Accueil</a></li>
            <li><a href="/public/contact.php" <?= basename($_SERVER['PHP_SELF']) == 'contact.php' ? 'class="active"' : '' ?>>Contact</a></li>
            <li><a href="/public/inscription.php" <?= basename($_SERVER['PHP_SELF']) == 'inscription.php' ? 'class="active"' : ''  ?>>Inscription</a></li>
            <li><a href="/public/connexion.php" <?= basename($_SERVER['PHP_SELF']) == 'connexion.php' ? 'class="active"' : ''  ?>>Connexion</a></li>
            <li><a href="/public/profil.php" <?= basename($_SERVER['PHP_SELF']) == 'profil.php' ? 'class="active"' : ''  ?>>Profil</a></li>
        </ul>
    </nav>
</header>
<!-- Balise <main> pour le contenu principal des pages -->
<main>
