<?php
// Fichier : profil.php
// Cette page affiche le profil de l'utilisateur connecté et permet la déconnexion.

// On inclut les fonctions de gestion de la base de données.
require_once __DIR__ . '/core/gestionBdd.php';

// On inclut les fonctions de gestion de l'authentification.
require_once __DIR__ . '/core/gestionAuthentification.php';

// Démarre ou reprend la session PHP.
session_start();

// Si l'utilisateur n'est pas connecté, le rediriger vers la page de connexion.
if (!est_connecte()) {
    header('Location: connexion.php');
    exit;
}

// Récupérer l'ID de l'utilisateur depuis la session.
$utilisateurId = $_SESSION['utilisateurId'];

// Tableau pour stocker les données utilisateur.
$utilisateur = null;
// Message de déconnexion réussie.
$messageDeconnexion = '';

// Si le formulaire de déconnexion est soumis.
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'deconnexion') {
    // Appeler la fonction de déconnexion.
    deconnecter_utilisateur();
    
    // Optionnel : on peut rediriger immédiatement vers la page d'accueil ou de connexion.
    header('Location: index.php');
    exit;
    // Ou rediriger vers connexion.php :
    // header('Location: connexion.php');
    // exit;
}

// Récupérer les informations de l'utilisateur depuis la base de données.
try {
    $pdo = obtenirConnexionBdd();
    
    $sql = '
        SELECT uti_id,
               uti_pseudo,
               uti_email
        FROM t_utilisateur_uti
        WHERE uti_id = :id
        LIMIT 1
    ';
    
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id', $utilisateurId, PDO::PARAM_INT);
    $stmt->execute();
    
    $utilisateur = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$utilisateur) {
        // L'utilisateur n'existe pas en base : il faut le déconnecter.
        deconnecter_utilisateur();
        header('Location: connexion.php');
        exit;
    }
} catch (PDOException $e) {
    echo "Erreur lors de la récupération du profil : " . $e->getMessage();
    exit;
}

// Définition des métadonnées de la page.
$pageTitre = "Profil";
$metaDescription = "Bienvenue sur votre page de profil.";

// Inclusion du header commun (titre, meta, menu).
require_once __DIR__ . '/templates/layout/header.php';
?>

<h1>Profil</h1>

<?php if ($utilisateur !== null) : ?>
    <div>
        <p>
            <strong>Pseudo :</strong> 
            <?= htmlspecialchars($utilisateur['uti_pseudo'], ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?>
        </p>
        <p>
            <strong>Email :</strong> 
            <?= htmlspecialchars($utilisateur['uti_email'], ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?>
        </p>
    </div>

    <!-- Formulaire de déconnexion -->
    <form action="" method="post">
        <input type="hidden" name="action" value="deconnexion">
        <button type="submit">Déconnexion</button>
    </form>
<?php else : ?>
    <p>Erreur : impossible de charger vos informations.</p>
<?php endif; ?>

<?php
// Inclusion du footer pour fermer correctement le HTML.
require_once __DIR__ . '/templates/layout/footer.php';
?>
