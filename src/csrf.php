<?php
// Fichier : /src/csrf.php
// Fonctions pour la protection CSRF (Cross-Site Request Forgery)

/**
 * Génère un token CSRF et le stocke en session
 * @return string Le token CSRF généré
 */
function genererTokenCSRF(): string
{
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

/**
 * Génère le champ hidden HTML pour le token CSRF
 * @return string Le HTML du champ hidden
 */
function champTokenCSRF(): string
{
    $token = genererTokenCSRF();
    return '<input type="hidden" name="csrf_token" value="' . htmlspecialchars($token, ENT_QUOTES, 'UTF-8') . '">';
}

/**
 * Vérifie si le token CSRF soumis est valide
 * @return bool True si le token est valide, False sinon
 */
function verifierTokenCSRF(): bool
{
    if (!isset($_SESSION['csrf_token']) || !isset($_POST['csrf_token'])) {
        return false;
    }

    return hash_equals($_SESSION['csrf_token'], $_POST['csrf_token']);
}

/**
 * Vérifie le token CSRF et arrête l'exécution si invalide
 * @param string|null $redirectUrl URL de redirection en cas d'échec (optionnel)
 */
function verifierCSRFOuMourir(?string $redirectUrl = null): void
{
    if (!verifierTokenCSRF()) {
        if ($redirectUrl) {
            $_SESSION['erreur_csrf'] = "Token de sécurité invalide. Veuillez réessayer.";
            header('Location: ' . $redirectUrl);
            exit;
        } else {
            http_response_code(403);
            die('Erreur de sécurité : Token CSRF invalide. Cette tentative a été enregistrée.');
        }
    }
}
?>
