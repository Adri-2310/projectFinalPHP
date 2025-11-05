<?php
$pageTitre = "Contact";
$metaDescription = "Contactez-nous via ce formulaire.";
include(__DIR__ . DIRECTORY_SEPARATOR . 'header.php');

// Initialisation des variables
$nom = $prenom = $email = $message = '';
$errors = [];
$successMessage = '';
$hasError = false;

// Traitement du formulaire si soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Nettoyage et validation des données
    $nom = trim($_POST['nom'] ?? '');
    $prenom = trim($_POST['prenom'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $message = trim($_POST['message'] ?? '');

    // Validation du champ "nom"
    if (empty($nom)) {
        $errors['nom'] = "Le nom est obligatoire.";
    } elseif (strlen($nom) < 2 || strlen($nom) > 255) {
        $errors['nom'] = "Le nom doit contenir entre 2 et 255 caractères.";
    }

    // Validation du champ "prénom"
    if (!empty($prenom) && (strlen($prenom) < 2 || strlen($prenom) > 255)) {
        $errors['prenom'] = "Le prénom doit contenir entre 2 et 255 caractères.";
    }

    // Validation du champ "email"
    if (empty($email)) {
        $errors['email'] = "L'email est obligatoire.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "L'email n'est pas valide.";
    }

    // Validation du champ "message"
    if (empty($message)) {
        $errors['message'] = "Le message est obligatoire.";
    } elseif (strlen($message) < 10 || strlen($message) > 3000) {
        $errors['message'] = "Le message doit contenir entre 10 et 3000 caractères.";
    }

    // Si aucune erreur, traitement réussi
    if (empty($errors)) {
        $successMessage = "Le formulaire a bien été envoyé !";
    } else {
        $hasError = true;
    }
}
?>

<h1>Contact</h1>

<?php if ($_SERVER['REQUEST_METHOD'] === 'POST'): ?>
    <?php if ($hasError): ?>
        <div class="alert error">
            Le formulaire contient des erreurs. Veuillez les corriger.
        </div>
    <?php else: ?>
        <div class="alert success">
            <?= $successMessage ?>
        </div>
    <?php endif; ?>
<?php endif; ?>

<form method="post" action="contact.php">
    <div class="form-group">
        <label for="nom">Nom *:</label>
        <input type="text" id="nom" name="nom" value="<?= htmlspecialchars($nom) ?>" required minlength="2" maxlength="255">
        <?php if (isset($errors['nom'])): ?>
            <span class="error-message"><?= $errors['nom'] ?></span>
        <?php endif; ?>
    </div>

    <div class="form-group">
        <label for="prenom">Prénom :</label>
        <input type="text" id="prenom" name="prenom" value="<?= htmlspecialchars($prenom) ?>" minlength="2" maxlength="255">
        <?php if (isset($errors['prenom'])): ?>
            <span class="error-message"><?= $errors['prenom'] ?></span>
        <?php endif; ?>
    </div>

    <div class="form-group">
        <label for="email">Email *:</label>
        <input type="email" id="email" name="email" value="<?= htmlspecialchars($email) ?>" required>
        <?php if (isset($errors['email'])): ?>
            <span class="error-message"><?= $errors['email'] ?></span>
        <?php endif; ?>
    </div>

    <div class="form-group">
        <label for="message">Message *:</label>
        <textarea id="message" name="message" required minlength="10" maxlength="3000"><?= htmlspecialchars($message) ?></textarea>
        <?php if (isset($errors['message'])): ?>
            <span class="error-message"><?= $errors['message'] ?></span>
        <?php endif; ?>
    </div>

    <div class="form-group">
        <button type="submit" class="btn">Envoyer</button>
    </div>
</form>

<?php include(__DIR__ . DIRECTORY_SEPARATOR . 'footer.php'); ?>
