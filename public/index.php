<?php
$pageTitre = "Accueil";
$metaDescription = "Bienvenue sur la page d'accueil de notre site web.";
require_once __DIR__ . '/../templates/layout/header.php';
?>

<div class="hero-section">
    <h1>Accueil</h1>
    <img src="/public/assets/images/logo.jpg?v=<?php echo time(); ?>" alt="Logo" class="logo-image">
</div>

<?php
// Inclusion du footer (fermeture des balises main/body/html).
require_once __DIR__ . '/../templates/layout/footer.php';
?>