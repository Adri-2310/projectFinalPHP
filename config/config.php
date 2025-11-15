<?php
// Fichier : /config/config.php.

// Active le mode développement.
// Ce mode permet notamment d'afficher les erreurs à l'écran pour faciliter le débogage.
// En production, cette constante devra être désactivée pour éviter de révéler des informations sensibles.
define('DEV_MODE', true);

// Retourne les paramètres nécessaires à la connexion à la base de données.
// Cette fonction centralise la configuration de la connexion, ce qui permet
// d'éviter de dupliquer ces informations dans tout le projet.
function obtenirConfigBdd(): array
{
    // On renvoie un tableau associatif contenant les informations de connexion.
    // À adapter selon votre configuration locale (nom de BDD, utilisateur, mot de passe).
    return [
        'serveur'     => 'localhost',
        'bdd'         => 'bdd_projet_web',
        'utilisateur' => 'root',
        'mdp'         => ''
    ];
}
?>