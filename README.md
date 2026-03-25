# GestTravaux — Application Web Symfony

Application web du projet GestTravaux (Symfony 7.2) pour la gestion des travaux immobiliers.  
Elle partage la même base de données MySQL que l'application Java Desktop.

## Prérequis

- **PHP 8.2+** avec les extensions : `pdo_mysql`, `intl`, `mbstring`, `gd`
- **Composer** (https://getcomposer.org)
- **MySQL 8.0** avec la base `gesttravaux` déjà créée par l'application Java

## Installation

```bash
# 1. Se placer dans le dossier du projet
cd "Partie Symfony"

# 2. Installer les dépendances
composer install

# 3. Configurer la base de données dans .env (déjà fait par défaut)
#    DATABASE_URL="mysql://root:studoo@127.0.0.1:3306/gesttravaux?serverVersion=8.0&charset=utf8mb4"

# 4. Exécuter les migrations (crée les tables web sans toucher aux tables Java)
php bin/console doctrine:migrations:migrate --no-interaction

# 5. Charger les données de test (utilisateurs)
php bin/console doctrine:fixtures:load --no-interaction
```

## Lancement du serveur

```bash
php -S 127.0.0.1:8000 -t public
```

L'application est accessible à : **http://127.0.0.1:8000**

## Comptes de test

| Rôle          | Email                        | Mot de passe      |
|---------------|------------------------------|--------------------|
| Admin         | admin@gesttravaux.fr         | admin123           |
| Inspecteur    | julie.martin@example.com     | inspecteur123      |
| Entrepreneur  | dupont@btp.fr                | entrepreneur123    |
| Propriétaire  | paul.durand@example.com      | proprietaire123    |

## Lancer les tests

```bash
php bin/phpunit
```

## Structure du projet

```
src/
├── Controller/       # Contrôleurs par rôle (Admin, Inspecteur, Entrepreneur, Propriétaire)
├── Entity/           # Entités Doctrine (tables Java mappées + tables web)
├── Repository/       # Repositories Doctrine
├── DataFixtures/     # Données de test
└── Security/         # Authentification
templates/            # Templates Twig (Bootstrap 5 + Leaflet.js)
config/               # Configuration Symfony, sécurité, VichUploader
public/uploads/       # Fichiers uploadés (documents, photos, devis)
```

## Rôles et fonctionnalités

- **Inspecteur** : consulter les chantiers assignés, localiser les biens sur carte, uploader documents/photos
- **Entrepreneur** : consulter les propositions de chantiers, accepter/refuser, soumettre des devis, suivre l'avancement
- **Propriétaire** : consulter ses biens et chantiers, valider les travaux
- **Admin** : gestion des utilisateurs, vue globale des chantiers
