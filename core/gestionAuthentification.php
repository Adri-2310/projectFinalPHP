<?php
// Fichier : /core/gestionAuthentification.php.
// Ce fichier regroupe toutes les fonctions liées à la gestion de l'authentification
// et des sessions utilisateur.

/**
 * Enregistre l'ID de l'utilisateur dans une variable de session.
 * Cette fonction permet de marquer qu'un utilisateur est connecté.
 *
 * @param int $utilisateurId ID de l'utilisateur à connecter.
 * @return void
 */
function connecter_utilisateur(int $utilisateurId): void
{
    // Stocker l'ID de l'utilisateur dans la session
    $_SESSION['utilisateurId'] = $utilisateurId;
}

/**
 * Vérifie si un utilisateur est actuellement connecté.
 * Consulte la variable de session pour déerminer l'état de connexion.
 *
 * @return bool true si l'utilisateur est connecté, false sinon.
 */
function est_connecte(): bool
{
    // Vérifier que la session contient une variable 'utilisateurId'
    return isset($_SESSION['utilisateurId']) && !empty($_SESSION['utilisateurId']);
}

/**
 * Déconnecte l'utilisateur actuellement connecté.
 * Supprime toutes les variables de session associées à l'utilisateur.
 *
 * @return void
 */
function deconnecter_utilisateur(): void
{
    // Supprimer la variable d'ID utilisateur de la session
    unset($_SESSION['utilisateurId']);
    
    // Optionnel : supprimer aussi les autres données utilisateur si elles existent
    unset($_SESSION['utilisateur_pseudo']);
    unset($_SESSION['utilisateur_email']);
    
    // Optionnel : détruire complètement la session
    // session_destroy();
}
?>
