<?php
// Fichier : /config/config.php.

/**
 * Charge les variables d'environnement depuis le fichier .env
 */
function chargerEnv(): void
{
    $envPath = dirname(__DIR__) . DIRECTORY_SEPARATOR . '.env';

    if (!file_exists($envPath)) {
        die('Erreur : le fichier .env est introuvable. Copiez .env.example vers .env et configurez-le.');
    }

    $lines = file($envPath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

    foreach ($lines as $line) {
        // Ignorer les commentaires
        if (strpos(trim($line), '#') === 0) {
            continue;
        }

        // Parser la ligne KEY=VALUE
        if (strpos($line, '=') !== false) {
            list($name, $value) = explode('=', $line, 2);
            $name = trim($name);
            $value = trim($value);

            // Stocker dans $_ENV et définir comme variable d'environnement
            $_ENV[$name] = $value;
            putenv("$name=$value");
        }
    }
}

// Charger les variables d'environnement
chargerEnv();

// Active le mode développement.
// Ce mode permet notamment d'afficher les erreurs à l'écran pour faciliter le débogage.
// En production, cette constante devra être désactivée pour éviter de révéler des informations sensibles.
define('DEV_MODE', $_ENV['APP_DEBUG'] === 'true');

// Retourne les paramètres nécessaires à la connexion à la base de données.
// Cette fonction centralise la configuration de la connexion, ce qui permet
// d'éviter de dupliquer ces informations dans tout le projet.
function obtenirConfigBdd(): array
{
    // On renvoie un tableau associatif contenant les informations de connexion
    // chargées depuis le fichier .env
    return [
        'serveur'     => $_ENV['DB_HOST'] ?? 'localhost',
        'bdd'         => $_ENV['DB_NAME'] ?? 'bdd_projet_web',
        'utilisateur' => $_ENV['DB_USER'] ?? 'root',
        'mdp'         => $_ENV['DB_PASS'] ?? ''
    ];
}
?>