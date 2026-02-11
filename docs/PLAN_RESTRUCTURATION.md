# PLAN DE RESTRUCTURATION DU PROJET

**Date**: 11 février 2026
**Objectif**: Transformer le projet en une structure professionnelle et maintenable

---

## 📊 STRUCTURE ACTUELLE (Problématique)

```
projectFinalPHP/
├── assets/css/style.css
├── config/config.php
├── core/
│   ├── gestionBdd.php
│   └── gestionErreurs.php
├── docs/RAPPORT_PROJET_PROGRESSIF.md
├── logs/erreurs.log
├── header.php              ❌ À la racine
├── footer.php              ❌ À la racine
├── index.php               ❌ À la racine
├── contact.php             ❌ À la racine
├── inscription.php         ❌ À la racine
├── connexion.php           ❌ À la racine
└── nul                     ❌ Fichier inutile
```

### Problèmes identifiés:
1. ❌ Fichiers PHP mélangés à la racine
2. ❌ Pas de séparation public/privé
3. ❌ Pas de dossier JavaScript
4. ❌ Pas de templates séparés
5. ❌ Pas de dossier src/ pour les classes
6. ❌ Pas de .htaccess de sécurité
7. ❌ Pas de fichier .env
8. ❌ Pas de fichier .gitignore complet

---

## 🎯 STRUCTURE CIBLE (Professionnelle)

```
projectFinalPHP/
│
├── public/                          # Point d'entrée web (DocumentRoot)
│   ├── index.php                    # Page d'accueil
│   ├── contact.php                  # Page contact
│   ├── inscription.php              # Page inscription
│   ├── connexion.php                # Page connexion
│   ├── deconnexion.php             # Page déconnexion
│   │
│   ├── assets/                      # Ressources publiques
│   │   ├── css/
│   │   │   ├── variables.css       # Variables CSS
│   │   │   ├── reset.css           # Reset CSS
│   │   │   ├── layout.css          # Layout global
│   │   │   ├── components.css      # Composants
│   │   │   └── style.css           # Import de tous les CSS
│   │   │
│   │   ├── js/
│   │   │   ├── classes/
│   │   │   │   └── HamburgerMenu.js
│   │   │   ├── api/
│   │   │   │   └── BlogAPI.js
│   │   │   └── main.js
│   │   │
│   │   ├── images/                 # Images du site
│   │   └── fonts/                  # Polices personnalisées
│   │
│   └── .htaccess                    # Configuration Apache
│
├── src/                             # Code source PHP
│   ├── Config/
│   │   └── Database.php            # Classe de connexion BDD
│   │
│   ├── Models/                     # Classes entités
│   │   ├── User.php
│   │   └── BaseModel.php
│   │
│   ├── Controllers/                # Logique métier
│   │   ├── AuthController.php
│   │   └── ContactController.php
│   │
│   ├── Services/                   # Services métier
│   │   ├── ValidationService.php
│   │   └── SecurityService.php
│   │
│   └── Helpers/                    # Fonctions utilitaires
│       ├── functions.php
│       └── security.php
│
├── templates/                       # Templates de vues
│   ├── layout/
│   │   ├── header.php
│   │   ├── footer.php
│   │   └── nav.php
│   │
│   └── pages/
│       ├── home.php
│       ├── contact-form.php
│       └── auth/
│           ├── login.php
│           └── register.php
│
├── config/                          # Configuration
│   ├── config.php                  # Configuration globale
│   ├── database.php                # Config BDD (charge .env)
│   └── session.php                 # Config sessions
│
├── database/                        # Fichiers SQL
│   ├── schema.sql                  # Structure des tables
│   ├── migrations/                 # Migrations SQL
│   └── seeds/                      # Données de test
│
├── storage/                         # Stockage privé
│   ├── logs/
│   │   ├── erreurs.log
│   │   └── access.log
│   └── uploads/                    # Fichiers uploadés
│
├── docs/                            # Documentation
│   ├── RAPPORT_PROJET_PROGRESSIF.md
│   ├── PLAN_RESTRUCTURATION.md
│   └── README.md
│
├── .env.example                     # Template de configuration
├── .env                             # Configuration locale (gitignored)
├── .gitignore                       # Fichiers à ignorer
├── .htaccess                        # Protection racine
└── README.md                        # Documentation projet
```

---

## 📋 PLAN DE MIGRATION ÉTAPE PAR ÉTAPE

### Phase 1: Préparation (Sauvegarde)
- [x] Créer ce plan de restructuration
- [ ] Créer un commit Git avant modifications
- [ ] Sauvegarder la base de données

### Phase 2: Créer la nouvelle structure
- [ ] Créer tous les dossiers nécessaires
- [ ] Créer les fichiers .htaccess de sécurité
- [ ] Créer le fichier .env.example

### Phase 3: Migration des fichiers existants
- [ ] Déplacer header.php → templates/layout/header.php
- [ ] Déplacer footer.php → templates/layout/footer.php
- [ ] Déplacer index.php → public/index.php
- [ ] Déplacer contact.php → public/contact.php
- [ ] Déplacer inscription.php → public/inscription.php
- [ ] Déplacer connexion.php → public/connexion.php
- [ ] Déplacer assets/ → public/assets/
- [ ] Déplacer core/gestionBdd.php → src/Config/Database.php (refactoriser)
- [ ] Déplacer core/gestionErreurs.php → src/Helpers/functions.php
- [ ] Déplacer config/config.php → config/config.php (adapter)

### Phase 4: Créer les nouveaux fichiers
- [ ] Créer public/assets/js/ avec les 3 exigences JS
- [ ] Créer config/session.php
- [ ] Créer config/database.php
- [ ] Créer database/schema.sql
- [ ] Créer public/deconnexion.php
- [ ] Créer .env et .env.example
- [ ] Créer .gitignore complet
- [ ] Créer .htaccess de sécurité

### Phase 5: Adapter les chemins
- [ ] Mettre à jour les chemins d'inclusion dans header.php
- [ ] Mettre à jour les chemins d'inclusion dans footer.php
- [ ] Mettre à jour les chemins dans les pages public/
- [ ] Mettre à jour les chemins CSS/JS

### Phase 6: Tests
- [ ] Tester page d'accueil
- [ ] Tester formulaire de contact
- [ ] Tester inscription
- [ ] Tester connexion
- [ ] Tester déconnexion
- [ ] Vérifier les logs d'erreurs

### Phase 7: Nettoyage
- [ ] Supprimer l'ancien dossier core/
- [ ] Supprimer le fichier "nul"
- [ ] Supprimer les anciens fichiers à la racine

---

## 🔧 COMMANDES DE MIGRATION

### Étape 1: Créer la structure de dossiers
```bash
# Créer la nouvelle structure
mkdir -p public/assets/{css,js/{classes,api},images,fonts}
mkdir -p src/{Config,Models,Controllers,Services,Helpers}
mkdir -p templates/{layout,pages/auth}
mkdir -p database/{migrations,seeds}
mkdir -p storage/{logs,uploads}
```

### Étape 2: Déplacer les fichiers
```bash
# Templates
mv header.php templates/layout/
mv footer.php templates/layout/

# Pages publiques
mv index.php public/
mv contact.php public/
mv connexion.php public/
mv inscription.php public/

# Assets
mv assets public/

# Logs
mv logs storage/
```

### Étape 3: Créer les fichiers de sécurité
Voir sections détaillées ci-dessous.

---

## 📄 FICHIERS À CRÉER

### 1. .env.example
```env
# Base de données
DB_HOST=localhost
DB_NAME=bdd_projet_web
DB_USER=root
DB_PASS=

# Application
APP_ENV=development
APP_DEBUG=true
APP_URL=http://localhost/projectFinalPHP

# Sécurité
SESSION_LIFETIME=3600
```

### 2. .gitignore
```gitignore
# Environment
.env
.env.local

# IDE
.idea/
.vscode/
*.swp
*.swo

# Logs
storage/logs/*.log
!storage/logs/.gitkeep

# Uploads
storage/uploads/*
!storage/uploads/.gitkeep

# OS
.DS_Store
Thumbs.db

# PHP
vendor/
composer.lock

# Temporary
nul
*.tmp
```

### 3. public/.htaccess
```apache
# Activation de la réécriture d'URL
RewriteEngine On

# Forcer HTTPS (en production)
# RewriteCond %{HTTPS} off
# RewriteRule ^(.*)$ https://%{HTTP_HOST}%{REQUEST_URI} [L,R=301]

# Sécurité - Cacher les fichiers sensibles
<FilesMatch "\.(env|log|sql|md)$">
    Require all denied
</FilesMatch>

# Headers de sécurité
Header set X-Content-Type-Options "nosniff"
Header set X-Frame-Options "DENY"
Header set X-XSS-Protection "1; mode=block"
Header set Referrer-Policy "strict-origin-when-cross-origin"

# Désactiver l'affichage des erreurs
php_flag display_errors off
php_flag display_startup_errors off
```

### 4. .htaccess (racine du projet)
```apache
# Interdire l'accès direct à la racine
Options -Indexes

# Bloquer l'accès aux dossiers sensibles
<IfModule mod_rewrite.c>
    RewriteEngine On

    # Rediriger vers le dossier public
    RewriteCond %{REQUEST_URI} !^/public/
    RewriteRule ^(.*)$ /public/$1 [L]
</IfModule>

# Protection des fichiers
<FilesMatch "\.(env|log|sql|md|json)$">
    Require all denied
</FilesMatch>
```

### 5. config/.htaccess
```apache
# Interdire l'accès aux fichiers de configuration
Require all denied
```

### 6. storage/.htaccess
```apache
# Interdire l'accès aux fichiers de stockage
Require all denied
```

### 7. src/.htaccess
```apache
# Interdire l'accès au code source
Require all denied
```

### 8. templates/.htaccess
```apache
# Interdire l'accès direct aux templates
Require all denied
```

---

## 🔄 ADAPTATIONS DE CODE NÉCESSAIRES

### 1. Adapter les inclusions dans public/index.php
```php
<?php
// AVANT
include(__DIR__ . DIRECTORY_SEPARATOR . 'header.php');

// APRÈS
require_once __DIR__ . '/../templates/layout/header.php';
```

### 2. Adapter les chemins CSS dans header.php
```php
<?php
// AVANT
<link rel="stylesheet" href="assets/css/style.css">

// APRÈS
<link rel="stylesheet" href="assets/css/style.css">
// (Reste identique car header.php est inclus depuis public/)
```

### 3. Créer config/session.php
```php
<?php
// Configuration sécurisée des sessions
ini_set('session.cookie_httponly', 1);
ini_set('session.cookie_secure', 1); // Si HTTPS
ini_set('session.cookie_samesite', 'Strict');
ini_set('session.use_strict_mode', 1);
ini_set('session.use_only_cookies', 1);
ini_set('session.gc_maxlifetime', 3600);

session_start();

// Régénérer l'ID de session pour nouvelles sessions
if (!isset($_SESSION['initiated'])) {
    session_regenerate_id(true);
    $_SESSION['initiated'] = true;
}
```

### 4. Créer config/database.php
```php
<?php
// Charger les variables d'environnement
function loadEnv($path) {
    if (!file_exists($path)) {
        return;
    }

    $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        if (strpos(trim($line), '#') === 0) {
            continue;
        }

        list($name, $value) = explode('=', $line, 2);
        $_ENV[trim($name)] = trim($value);
    }
}

loadEnv(__DIR__ . '/../.env');

return [
    'host' => $_ENV['DB_HOST'] ?? 'localhost',
    'dbname' => $_ENV['DB_NAME'] ?? 'bdd_projet_web',
    'user' => $_ENV['DB_USER'] ?? 'root',
    'pass' => $_ENV['DB_PASS'] ?? '',
    'charset' => 'utf8mb4'
];
```

---

## ⚠️ POINTS D'ATTENTION

### Avant de commencer:
1. ✅ Faire un commit Git de l'état actuel
2. ✅ Sauvegarder la base de données
3. ✅ Tester que l'application fonctionne avant migration

### Pendant la migration:
1. ⚠️ Déplacer un fichier à la fois
2. ⚠️ Tester après chaque déplacement
3. ⚠️ Vérifier les chemins relatifs

### Après la migration:
1. ✅ Tester toutes les pages
2. ✅ Vérifier les logs d'erreurs
3. ✅ Valider que les assets se chargent
4. ✅ Tester l'authentification complète

---

## 📈 AVANTAGES DE LA NOUVELLE STRUCTURE

### Sécurité ✅
- Séparation public/privé
- Fichiers sensibles inaccessibles via HTTP
- Configuration dans .env
- .htaccess de protection

### Maintenabilité ✅
- Organisation logique par responsabilité
- Séparation templates/logique
- Structure claire et prévisible

### Professionnalisme ✅
- Respect des standards de l'industrie
- Évolutivité facilitée
- Collaboration simplifiée

### Performance ✅
- Assets organisés
- Cache des templates possible
- Optimisation future facilitée

---

## 📚 PROCHAINES ÉTAPES APRÈS RESTRUCTURATION

1. Implémenter les 3 exigences JavaScript
2. Ajouter les protections CSRF
3. Créer les classes Model en POO
4. Implémenter le CRUD complet
5. Ajouter le responsive design CSS
6. Créer la page de déconnexion
7. Ajouter les tests

---

**Note**: Ce plan est conçu pour être exécuté étape par étape avec validation à chaque phase.
