<?php
// Fichier : /config/session.php
// Configuration sécurisée des sessions PHP

// Charger la configuration pour accéder aux variables d'environnement
require_once __DIR__ . DIRECTORY_SEPARATOR . 'config.php';

// Configuration sécurisée des cookies de session
ini_set('session.cookie_httponly', $_ENV['SESSION_COOKIE_HTTPONLY'] ?? '1');
ini_set('session.cookie_secure', $_ENV['SESSION_COOKIE_SECURE'] ?? '0'); // Mettre à 1 si HTTPS
ini_set('session.cookie_samesite', $_ENV['SESSION_COOKIE_SAMESITE'] ?? 'Strict');
ini_set('session.use_strict_mode', '1');
ini_set('session.use_only_cookies', '1');
ini_set('session.gc_maxlifetime', $_ENV['SESSION_LIFETIME'] ?? '3600');

// Démarrer la session
session_start();

// Régénérer l'ID de session pour les nouvelles sessions
if (!isset($_SESSION['initiated'])) {
    session_regenerate_id(true);
    $_SESSION['initiated'] = true;
    $_SESSION['created_at'] = time();
}

// Vérifier l'expiration de la session (timeout)
$sessionLifetime = (int)($_ENV['SESSION_LIFETIME'] ?? 3600);
if (isset($_SESSION['created_at']) && (time() - $_SESSION['created_at'] > $sessionLifetime)) {
    // Session expirée
    session_unset();
    session_destroy();
    session_start();
    session_regenerate_id(true);
    $_SESSION['initiated'] = true;
    $_SESSION['created_at'] = time();
}

// Mettre à jour le timestamp de dernière activité
$_SESSION['last_activity'] = time();
?>
