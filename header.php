<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <!-- Balise meta pour adapter l'affichage sur les écrans mobiles -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Description de la page, définie dans chaque fichier PHP avant l'inclusion du header -->
    <meta name="description" content="<?=$metaDescription?>">
    <title><?=$pageTitre?></title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
<header>
    <nav>
        <ul>
            <li><a href="index.php" <?= basename($_SERVER['PHP_SELF']) == 'index.php' ? 'class="active"' : '' ?>>Accueil</a></li>
            <li><a href="contact.php" <?= basename($_SERVER['PHP_SELF']) == 'contact.php' ? 'class="active"' : '' ?>>Contact</a></li>
            <li><a href="inscription.php" <?= basename($_SERVER['PHP_SELF']) == 'inscription.php' ? 'class="active"' : ''  ?>>Inscription</a></li>
            <li><a href="connexion.php" <?= basename($_SERVER['PHP_SELF']) == 'connexion.php' ? 'class="active"' : ''  ?>>Connexion</a></li>
        </ul>
    </nav>
</header>
<!-- Balise <main> pour le contenu principal des pages -->
<main>
