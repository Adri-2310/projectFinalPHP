<?php
// Fichier : inscription.php.
// Cette page permet à un nouvel utilisateur de créer un compte (inscription).

// On inclut les fonctions de gestion de la base de données (connexion, insertion, etc.).
require_once(__DIR__ ).DIRECTORY_SEPARATOR.'core'.DIRECTORY_SEPARATOR.'gestionBdd.php';

// On inclut les fonctions de gestion de l'authentification.
require_once(__DIR__ ).DIRECTORY_SEPARATOR.'core'.DIRECTORY_SEPARATOR.'gestionAuthentification.php';

// Démarre ou reprend la session PHP pour pouvoir stocker des informations utilisateur.
session_start();

// Si l'utilisateur est déjà connecté, le rediriger vers la page de profil.
if (est_connecte()) {
    header('Location: profil.php');
    exit;
}

// Définir les métadonnées de la page (utilisées dans header.php).
$pageTitre = "Inscription";
$metaDescription = "Bienvenue sur la page d'inscription de notre site web.";

// Gestionnaire du formulaire d'inscription.
// $erreurs contiendra la liste des messages d'erreur (si validations échouent).
$erreurs = [];
// $succes indiquera si l'inscription a réussi.
$succes = false;
// Variables pour mémoriser les valeurs saisies (afin de les réafficher en cas d'erreur).
$pseudo = '';
$email = '';

// Vérifier si le formulaire a été soumis via la méthode POST.
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupération et nettoyage des données du formulaire.
    $pseudo   = isset($_POST['inscription_pseudo']) ? trim($_POST['inscription_pseudo']) : '';
    $email    = isset($_POST['inscription_email']) ? trim($_POST['inscription_email']) : '';
    $password = isset($_POST['inscription_motDePasse']) ? $_POST['inscription_motDePasse'] : '';
    $passwordConfirm = isset($_POST['inscription_motDePasse_confirmation']) ? $_POST['inscription_motDePasse_confirmation'] : '';

    // ---------------------------
    // Validation du champ PSEUDO
    // ---------------------------
    if ($pseudo === '') {
        $erreurs[] = "Le pseudo est obligatoire.";
    } elseif (strlen($pseudo) < 2) {
        $erreurs[] = "Le pseudo doit contenir au moins 2 caractères.";
    } elseif (strlen($pseudo) > 255) {
        $erreurs[] = "Le pseudo ne peut pas dépasser 255 caractères.";
    } elseif (!isPseudoDisponible($pseudo)) {
        // Vérification en base via la fonction définie dans gestionBdd.php.
        $erreurs[] = "Ce pseudo est déjà utilisé. Veuillez en choisir un autre.";
    }

    // ---------------------------
    // Validation du champ EMAIL
    // ---------------------------
    if ($email === '') {
        $erreurs[] = "L'email est obligatoire.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $erreurs[] = "L'email n'est pas valide.";
    }

    // --------------------------------
    // Validation du champ MOT DE PASSE
    // --------------------------------
    if ($password === '') {
        $erreurs[] = "Le mot de passe est obligatoire.";
    } elseif (strlen($password) < 8) {
        $erreurs[] = "Le mot de passe doit contenir au moins 8 caractères.";
    } elseif (strlen($password) > 72) {
        $erreurs[] = "Le mot de passe ne peut pas dépasser 72 caractères.";
    }

    // ------------------------------------------------
    // Validation du champ CONFIRMATION MOT DE PASSE
    // ------------------------------------------------
    if ($passwordConfirm === '') {
        $erreurs[] = "La confirmation du mot de passe est obligatoire.";
    } elseif ($password !== $passwordConfirm) {
        $erreurs[] = "Les mots de passe ne correspondent pas.";
    }

    // Si aucune erreur n'a été détectée, on peut enregistrer l'utilisateur.
    if (empty($erreurs)) {
        // Hachage sécurisé du mot de passe avant stockage en base.
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);

        // Insertion de l'utilisateur dans la base via la fonction du fichier core/gestionBdd.php.
        addNewUser($pseudo, $email, $passwordHash);

        // Indiquer que l'inscription s'est bien passée.
        $succes = true;

        // Réinitialiser les champs (plus besoin de les réafficher).
        $pseudo = '';
        $email = '';
    }
}

// Inclusion du header (titre, meta, menu).
include (__DIR__ . DIRECTORY_SEPARATOR . 'header.php');
?>

<h1>Inscription</h1>

<?php if (!empty($erreurs)) : ?>
    <div class="error-container">
        <ul>
            <?php foreach ($erreurs as $erreur) : ?>
                <li><?= htmlspecialchars($erreur, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<?php if ($succes) : ?>
    <div class="success-container">
        Votre inscription a été réalisée avec succès.
    </div>
<?php endif; ?>

<form action="" method="post">
    <div class="form-group">
        <label for="inscription_pseudo">Pseudo</label>
        <input
            type="text"
            id="inscription_pseudo"
            name="inscription_pseudo"
            required
            minlength="2"
            maxlength="255"
            value="<?= htmlspecialchars($pseudo, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?>"
        >
    </div>

    <div class="form-group">
        <label for="inscription_email">Email</label>
        <input
            type="email"
            id="inscription_email"
            name="inscription_email"
            required
            value="<?= htmlspecialchars($email, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?>"
        >
    </div>

    <div class="form-group">
        <label for="inscription_motDePasse">Mot de passe</label>
        <input
            type="password"
            id="inscription_motDePasse"
            name="inscription_motDePasse"
            required
            minlength="8"
            maxlength="72"
        >
    </div>

    <div class="form-group">
        <label for="inscription_motDePasse_confirmation">Confirmation du mot de passe</label>
        <input
            type="password"
            id="inscription_motDePasse_confirmation"
            name="inscription_motDePasse_confirmation"
            required
            minlength="8"
            maxlength="72"
        >
    </div>

    <button type="submit">S'inscrire</button>
</form>

<?php
// Inclusion du footer (fermeture des balises HTML).
include(__DIR__ . DIRECTORY_SEPARATOR . 'footer.php');
?>

