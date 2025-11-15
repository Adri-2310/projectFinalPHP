<?php
// Fichier : /core/gestionErreurs.php.
// Ce fichier contient une fonction utilitaire pour gérer les exceptions globales de l'application.

// Charger le fichier de configuration globale ("config.php").
// Ce fichier contient, entre autres, la constante "DEV_MODE" utilisée ici pour déterminer
// si les erreurs doivent être affichées à l'écran ou non.
//
// Même si ce fichier est déjà inclus ailleurs dans l'application (comme dans "gestionBdd.php"),
// on préfère l'inclure à nouveau ici pour être sûr que les informations soient disponibles,
// notamment si cette fonction est utilisée de manière autonome.
//
// La fonction "require_once" permet de ne charger le fichier qu'une seule fois, même si
// plusieurs scripts essaient de l'inclure : cela évite les doublons ou erreurs de redéfinition.
require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'config.php';

/**
 * Gère les exceptions levées dans l'application.
 *
 * @param Exception $e Exception capturée.
 */
function gererExceptions(Exception $e): void
{
    // Si on est en mode développement, on affiche directement l'erreur à l'écran.
    if (defined('DEV_MODE') && DEV_MODE === true)
    {
        echo 'Une erreur est survenue : ' . $e->getMessage();
    }
    else
    {
        // En mode production, on n'affiche pas le détail des erreurs à l'utilisateur.
        // À la place, on les enregistre dans un fichier de log.

        // Définir le chemin complet vers le fichier de log des erreurs.
        $cheminLog = dirname(__DIR__) . DIRECTORY_SEPARATOR . 'logs' . DIRECTORY_SEPARATOR . 'erreurs.log';

        // Construire un message d'erreur horodaté, contenant la date et l'heure suivies du message de l'exception.
        $message = date('[Y-m-d H:i:s]') . $e->getMessage();

        // Enregistrer le message dans le fichier de log.
        // Le paramètre "3" indique à error_log() d'écrire dans un fichier personnalisé.
        error_log($message, 3, $cheminLog);
    }
}
?>