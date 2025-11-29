<?php
$pageTitre = "Accueil";
$metaDescription = "Bienvenue sur la page d'accueil de notre site web.";
include(__DIR__ . DIRECTORY_SEPARATOR . 'header.php');
?>

<div class="hero-section">
    <h1>Accueil</h1>
    <img src="/assets/images/logo.jpg?v=<?php echo time(); ?>" alt="Logo" class="logo-image">
</div>

<?php
// Inclusion du footer (fermeture des balises main/body/html).
include(__DIR__ . DIRECTORY_SEPARATOR . 'footer.php');
?>