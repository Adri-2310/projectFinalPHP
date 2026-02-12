<?php
// Fichier : contact.php.
// Cette page affiche un formulaire de contact simple avec validations côté serveur.

// Définition du titre et de la description de la page.
$pageTitre = "Contact";
$metaDescription = "Contactez-nous via ce formulaire.";

// Inclusion du header (structure HTML + menu).
require_once __DIR__ . '/../templates/layout/header.php';

// Initialisation des variables avec des valeurs vides.
$nom = $prenom = $email = $message = '';
// Tableau associatif qui contiendra les messages d'erreurs pour chaque champ.
$errors = [];
// Message global de succès affiché si l'envoi est considéré comme valide.
$successMessage = '';
// Indicateur permettant de savoir si le formulaire contient au moins une erreur.
$hasError = false;

// Traitement du formulaire si celui-ci a été soumis en POST.
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Nettoyage et récupération des données envoyées par l'utilisateur.
    $nom = trim($_POST['nom'] ?? '');
    $prenom = trim($_POST['prenom'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $message = trim($_POST['message'] ?? '');

    // --------------------------------
    // Validation du champ "nom"
    // --------------------------------
    if (empty($nom)) {
        $errors['nom'] = "Le nom est obligatoire.";
    } elseif (strlen($nom) < 2 || strlen($nom) > 255) {
        $errors['nom'] = "Le nom doit contenir entre 2 et 255 caractères.";
    }

    // --------------------------------
    // Validation du champ "prénom"
    // --------------------------------
    if (!empty($prenom) && (strlen($prenom) < 2 || strlen($prenom) > 255)) {
        $errors['prenom'] = "Le prénom doit contenir entre 2 et 255 caractères.";
    }

    // --------------------------------
    // Validation du champ "email"
    // --------------------------------
    if (empty($email)) {
        $errors['email'] = "L'email est obligatoire.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "L'email n'est pas valide.";
    }

    // --------------------------------
    // Validation du champ "message"
    // --------------------------------
    if (empty($message)) {
        $errors['message'] = "Le message est obligatoire.";
    } elseif (strlen($message) < 10 || strlen($message) > 3000) {
        $errors['message'] = "Le message doit contenir entre 10 et 3000 caractères.";
    }

    // Si aucune erreur n'a été détectée, on considère que l'envoi est un succès.
    // (Ici, aucun envoi d'email réel n'est réalisé, on se limite au message de confirmation.)
    if (empty($errors)) {
        $successMessage = "Le formulaire a bien été envoyé !";
    } else {
        // Indique qu'au moins une erreur est présente.
        $hasError = true;
    }
}
?>

<h1>Contact</h1>

<?php if ($_SERVER['REQUEST_METHOD'] === 'POST'): ?>
    <?php if ($hasError): ?>
        <!-- Message global si le formulaire contient des erreurs -->
        <div class="error-container">
            Le formulaire contient des erreurs. Veuillez les corriger.
        </div>
    <?php else: ?>
        <!-- Message global si le formulaire est correct -->
        <div class="success-container">
            <?= $successMessage ?>
        </div>
    <?php endif; ?>
<?php endif; ?>

<!-- Formulaire de contact -->
<form method="post" action="contact.phpphp">
    <div class="form-group">
        <label for="nom">Nom *:</label>
        <input
            type="text"
            id="nom"
            name="nom"
            value="<?= htmlspecialchars($nom) ?>"
            required
            minlength="2"
            maxlength="255"
        >
        <?php if (isset($errors['nom'])): ?>
            <!-- Affichage du message d'erreur spécifique au champ "nom" -->
            <span class="error-message"><?= $errors['nom'] ?></span>
        <?php endif; ?>
    </div>

    <div class="form-group">
        <label for="prenom">Prénom :</label>
        <input
            type="text"
            id="prenom"
            name="prenom"
            value="<?= htmlspecialchars($prenom) ?>"
            minlength="2"
            maxlength="255"
        >
        <?php if (isset($errors['prenom'])): ?>
            <!-- Affichage du message d'erreur spécifique au champ "prénom" -->
            <span class="error-message"><?= $errors['prenom'] ?></span>
        <?php endif; ?>
    </div>

    <div class="form-group">
        <label for="email">Email *:</label>
        <input
            type="email"
            id="email"
            name="email"
            value="<?= htmlspecialchars($email) ?>"
            required
        >
        <?php if (isset($errors['email'])): ?>
            <!-- Affichage du message d'erreur spécifique au champ "email" -->
            <span class="error-message"><?= $errors['email'] ?></span>
        <?php endif; ?>
    </div>

    <div class="form-group">
        <label for="message">Message *:</label>
        <textarea
            id="message"
            name="message"
            required
            minlength="10"
            maxlength="3000"
        ><?= htmlspecialchars($message) ?></textarea>
        <?php if (isset($errors['message'])): ?>
            <!-- Affichage du message d'erreur spécifique au champ "message" -->
            <span class="error-message"><?= $errors['message'] ?></span>
        <?php endif; ?>
    </div>

    <div class="form-group">
        <!-- Bouton d'envoi du formulaire -->
        <button type="submit" class="btn">Envoyer</button>
    </div>
</form>

<?php
// Inclusion du footer pour fermer correctement les balises HTML.
require_once __DIR__ . '/../templates/layout/footer.php';
?>
