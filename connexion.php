<?php
// Fichier : connexion.php.
// Cette page permet à un utilisateur existant de se connecter à son compte.

// On inclut les fonctions de gestion de la base de données (connexionUser, etc.).
require_once __DIR__ . DIRECTORY_SEPARATOR . 'core' . DIRECTORY_SEPARATOR . 'gestionBdd.php';

// Définition des métadonnées de la page (titre + description).
$pageTitre = "Connexion";
$metaDescription = "Bienvenue sur la page de connexion de notre site web.";

// Démarre ou reprend la session PHP pour pouvoir stocker des informations utilisateur.
session_start();

// Tableau pour stocker les messages d'erreurs de validation ou de connexion.
$erreurs = [];
// Message affiché en cas de connexion réussie.
$messageSucces = '';
// Variable pour mémoriser le pseudo saisi.
$pseudo = '';

// Vérifier si le formulaire a été soumis.
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupération et nettoyage des champs du formulaire.
    $pseudo = isset($_POST['connexion_pseudo']) ? trim($_POST['connexion_pseudo']) : '';
    $motDePasse = isset($_POST['connexion_motDePasse']) ? $_POST['connexion_motDePasse'] : '';

    // ---------------------------
    // Validations basiques
    // ---------------------------

    // Validation du pseudo.
    if ($pseudo === '') {
        $erreurs[] = "Le pseudo est obligatoire.";
    } elseif (strlen($pseudo) < 2 || strlen($pseudo) > 255) {
        $erreurs[] = "Le pseudo doit contenir entre 2 et 255 caractères.";
    }

    // Validation du mot de passe.
    if ($motDePasse === '') {
        $erreurs[] = "Le mot de passe est obligatoire.";
    } elseif (strlen($motDePasse) < 8 || strlen($motDePasse) > 72) {
        $erreurs[] = "Le mot de passe doit contenir entre 8 et 72 caractères.";
    }

    // Si aucune erreur de validation, on tente de connecter l'utilisateur.
    if (empty($erreurs)) {
        // Appel de la fonction connexionUser définie dans gestionBdd.php.
        $utilisateur = connexionUser($pseudo, $motDePasse);

        if ($utilisateur === null) {
            // Soit le pseudo n'existe pas, soit le mot de passe est erroné, soit le compte est inactif.
            $erreurs[] = "Identifiants invalides ou compte inactif.";
        } else {
            // Connexion réussie : on stocke quelques informations dans la session.
            $_SESSION['utilisateur_id']    = $utilisateur['uti_id'];
            $_SESSION['utilisateur_pseudo'] = $utilisateur['uti_pseudo'];
            $_SESSION['utilisateur_email']  = $utilisateur['uti_email'];

            // Message de confirmation personnalisé.
            $messageSucces = "Connexion réussie. Bonjour " . htmlspecialchars($utilisateur['uti_pseudo'], ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') . " !";
        }
    }
}

// Inclusion du header commun (titre, meta, menu).
include (__DIR__ . DIRECTORY_SEPARATOR . 'header.php');
?>

<h1>Connexion</h1>

<?php if (!empty($erreurs)) : ?>
    <!-- Affichage des erreurs de connexion / validation -->
    <div style="color: red;">
        <ul>
            <?php foreach ($erreurs as $erreur) : ?>
                <li><?= htmlspecialchars($erreur, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<?php if ($messageSucces !== '') : ?>
    <!-- Affichage du message de succès si la connexion a réussi -->
    <div style="color: green;">
        <?= $messageSucces ?>
    </div>
<?php endif; ?>

<!-- Formulaire de connexion -->
<form action="" method="post">
    <div>
        <label for="connexion_pseudo">Pseudo</label>
        <input
            type="text"
            id="connexion_pseudo"
            name="connexion_pseudo"
            required
            minlength="2"
            maxlength="255"
            value="<?= htmlspecialchars($pseudo, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?>"
        >
    </div>

    <div>
        <label for="connexion_motDePasse">Mot de passe</label>
        <input
            type="password"
            id="connexion_motDePasse"
            name="connexion_motDePasse"
            required
            minlength="8"
            maxlength="72"
        >
    </div>

    <button type="submit">Se connecter</button>
</form>

<p>
    Pas encore de compte ?
    <a href="inscription.php">Inscrivez-vous</a>.
</p>

<?php
// Inclusion du footer pour fermer correctement le HTML.
include(__DIR__ . DIRECTORY_SEPARATOR . 'footer.php');
?>
