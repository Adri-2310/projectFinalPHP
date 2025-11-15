<?php
// Fichier : /core/gestionBdd.php.
// Ce fichier regroupe toutes les fonctions liées à la gestion de la base de données.

// Importer les dépendances (configuration de la BDD).
require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'config.php';

/**
 * Établit et retourne une connexion PDO à la base de données.
 *
 * @return PDO Connexion à la base de données.
 */
function obtenirConnexionBdd(): PDO
{
    // Récupérer la configuration permettant d'établir une connexion à la base de données.
    $config = obtenirConfigBdd();

    // Construire le DSN (Data Source Name) pour MySQL.
    $dsn = "mysql:host={$config['serveur']};dbname={$config['bdd']};charset=utf8mb4";

    // Établir la connexion à la base de données avec PDO.
    $pdo = new PDO($dsn, $config['utilisateur'], $config['mdp']);

    // Activer le mode Exception pour que PDO lance des exceptions en cas d'erreur SQL.
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    return $pdo;
}

/**
 * Ajoute un nouvel utilisateur dans la table t_utilisateur_uti.
 *
 * @param string $pseudo       Pseudo de l'utilisateur (doit être unique).
 * @param string $email        Email de l'utilisateur (doit être unique).
 * @param string $passwordHash Hash du mot de passe (généré par password_hash()).
 */
function addNewUser(string $pseudo, string $email, string $passwordHash): void
{
    try {
        // On récupère une connexion à la base de données.
        $pdo = obtenirConnexionBdd();

        // Requête SQL d'insertion dans la table t_utilisateur_uti.
        $requete = '
            INSERT INTO t_utilisateur_uti (
                uti_pseudo,
                uti_email,
                uti_motdepasse,
                uti_compte_active,
                uti_code_activation
            ) VALUES (
                :pseudo,
                :email,
                :motdepasse,
                :compte_active,
                :code_activation
            )
        ';

        // Préparation de la requête pour éviter les injections SQL.
        $stmt = $pdo->prepare($requete);

        // Par défaut, on active le compte et on ne définit pas de code d'activation.
        $compteActive   = 1;
        $codeActivation = null;

        // Association des paramètres nommés aux valeurs PHP.
        $stmt->bindParam(':pseudo', $pseudo);
        $stmt->bindParam(':email', $email );
        $stmt->bindParam(':motdepasse', $passwordHash);
        $stmt->bindParam(':compte_active', $compteActive);
        $stmt->bindParam(':code_activation', $codeActivation);

        // Exécution de la requête SQL.
        $stmt->execute();
    } catch (PDOException $e) {
        // En environnement de production, il serait préférable de loguer l'erreur plutôt que de l'afficher.
        echo "Erreur lors de l'ajout de l'utilisateur : " . $e->getMessage();
    } finally {
        // On ferme proprement la connexion si elle existe.
        if (isset($pdo)) {
            $pdo = null;
        }
    }
}

/**
 * Vérifie si un pseudo est disponible (non encore utilisé dans la table t_utilisateur_uti).
 *
 * @param string $pseudo Pseudo à vérifier.
 * @return bool true si le pseudo n'existe pas encore, false sinon.
 */
function isPseudoDisponible(string $pseudo): bool
{
    try {
        // Connexion à la base de données.
        $pdo = obtenirConnexionBdd();

        // Requête SQL : on compte le nombre de lignes ayant ce pseudo.
        $sql = 'SELECT COUNT(*) AS nb FROM t_utilisateur_uti WHERE uti_pseudo = :pseudo';
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':pseudo', $pseudo);
        $stmt->execute();

        // On récupère la première (et unique) ligne de résultat.
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        // Si "nb" > 0, le pseudo est déjà pris → non disponible.
        if ($row && (int)$row['nb'] > 0) {
            return false;
        }

        // Sinon, le pseudo est disponible.
        return true;
    } catch (PDOException $e) {
        // En production, on logue l'erreur. Ici, on affiche et on considère le pseudo comme non disponible.
        echo "Erreur lors de la vérification du pseudo : " . $e->getMessage();
        return false;
    } finally {
        // Fermeture de la connexion.
        if (isset($pdo)) {
            $pdo = null;
        }
    }
}

/**
 * Tente de connecter un utilisateur à partir de son pseudo et de son mot de passe.
 *
 * @param string $pseudo      Pseudo saisi dans le formulaire.
 * @param string $motDePasse  Mot de passe en clair saisi dans le formulaire.
 *
 * @return array|null  Retourne les données de l'utilisateur si la connexion réussit, sinon null.
 */
function connexionUser(string $pseudo, string $motDePasse): ?array
{
    try {
        // Connexion à la base de données.
        $pdo = obtenirConnexionBdd();

        // Requête SQL : on récupère l'utilisateur correspondant au pseudo fourni.
        $sql = '
            SELECT uti_id,
                   uti_pseudo,
                   uti_email,
                   uti_motdepasse,
                   uti_compte_active,
                   uti_code_activation
            FROM t_utilisateur_uti
            WHERE uti_pseudo = :pseudo
            LIMIT 1
        ';

        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':pseudo', $pseudo);
        $stmt->execute();

        // Récupération des données utilisateur.
        $utilisateur = $stmt->fetch(PDO::FETCH_ASSOC);

        // Si aucun utilisateur trouvé, on retourne null.
        if (!$utilisateur) {
            return null;
        }

        // Vérifier si le compte est actif (si votre logique prévoit des comptes désactivés).
        if (isset($utilisateur['uti_compte_active']) && (int)$utilisateur['uti_compte_active'] !== 1) {
            return null;
        }

        // Récupération du hash du mot de passe stocké en base (VARBINARY).
        $hash = $utilisateur['uti_motdepasse'];

        // Vérification du mot de passe en clair avec le hash stocké.
        if (!password_verify($motDePasse, $hash)) {
            // Mot de passe incorrect → connexion échouée.
            return null;
        }

        // Connexion réussie : on retourne le tableau associatif contenant les infos utilisateur.
        return $utilisateur;

    } catch (PDOException $e) {
        // En production : log de l'erreur dans un fichier.
        echo "Erreur lors de la connexion de l'utilisateur : " . $e->getMessage();
        return null;
    } finally {
        // Fermeture de la connexion.
        if (isset($pdo)) {
            $pdo = null;
        }
    }
}
?>