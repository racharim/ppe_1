<div align="center">

# MANUEL D'INSTALLATION

### Application PPE_1 — Gestion d'activités sportives

</div>

---

| | |
|---|---|
| **Projet** | PPE_1 |
| **Document** | Manuel d'installation |
| **Version** | 2.0 |
| **Date** | 14/04/2026 |
| **Destinataires** | Développeur, enseignant, administrateur technique |
| **Confidentialité** | Usage interne au projet |

---

## Sommaire

1. [Objet du document](#1-objet-du-document)
2. [Prérequis techniques](#2-prérequis-techniques)
3. [Installation des fichiers du projet](#3-installation-des-fichiers-du-projet)
4. [Initialisation de la base de données](#4-initialisation-de-la-base-de-données)
5. [Configuration applicative](#5-configuration-applicative)
6. [Démarrage de l'application](#6-démarrage-de-lapplication)
7. [Vérification post-installation](#7-vérification-post-installation)
8. [Résolution des incidents](#8-résolution-des-incidents)
9. [Procédure de mise à jour](#9-procédure-de-mise-à-jour)
10. [Annexes](#10-annexes)

---

## 1. Objet du document

Ce document décrit la procédure complète d'installation, de configuration et de vérification de l'application **PPE_1** sur un environnement local Windows équipé de WAMP. Il s'adresse à toute personne devant déployer l'application depuis les sources.

## 2. Prérequis techniques

### 2.1 Environnement matériel et logiciel

| Composant | Exigence |
|---|---|
| Système d'exploitation | Windows 10 / 11 |
| Serveur local | WAMP 3.x installé et fonctionnel |
| Serveur HTTP | Apache (inclus dans WAMP) |
| Base de données | MySQL ou MariaDB (inclus dans WAMP) |
| Administration BDD | phpMyAdmin (inclus dans WAMP) |
| Navigateur web | Chrome, Firefox ou Edge (version récente) |
| Espace disque | Minimum 100 Mo disponibles |

### 2.2 Ressources nécessaires

| Ressource | Localisation |
|---|---|
| Dossier du projet | `c:/wamp64/www/ppe_1` |
| Script SQL d'initialisation | `public/ppe_1 (5).sql` |
| Fichier de configuration BDD | `config/database.php` |

## 3. Installation des fichiers du projet

### 3.1 Déploiement des sources

1. Copier l'intégralité du dossier du projet dans le répertoire web de WAMP :
   ```
   c:/wamp64/www/ppe_1
   ```

2. Vérifier la présence de l'arborescence suivante :

   ```
   ppe_1/
   ├── app/
   │   ├── controller/
   │   ├── modele/
   │   └── vue/
   ├── config/
   ├── public/
   └── themes/
   ```

### 3.2 Contrôle d'intégrité

Vérifier l'existence des fichiers critiques :

| Fichier | Rôle |
|---|---|
| `public/index.php` | Point d'entrée de l'application |
| `config/database.php` | Configuration de la connexion à la base de données |
| `public/ppe_1 (5).sql` | Script de création et d'alimentation de la base |

> **Important :** Si l'un de ces fichiers est absent, l'installation ne pourra pas aboutir.

## 4. Initialisation de la base de données

### 4.1 Création de la base

1. Ouvrir phpMyAdmin dans le navigateur :
   ```
   http://localhost/phpmyadmin
   ```
2. Cliquer sur **Nouvelle base de données**.
3. Saisir le nom de la base (exemple : `ppe_1`).
4. Sélectionner l'interclassement **utf8mb4_general_ci**.
5. Cliquer sur **Créer**.

### 4.2 Import du schéma et des données

1. Sélectionner la base nouvellement créée dans le volet gauche.
2. Accéder à l'onglet **Importer**.
3. Cliquer sur **Choisir un fichier** et sélectionner :
   ```
   public/ppe_1 (5).sql
   ```
4. Cliquer sur **Exécuter**.

> **Résultat attendu :** L'import se termine sans erreur. Les tables apparaissent dans le volet gauche de phpMyAdmin.

### 4.3 Vérification de l'import

| Vérification | Critère de succès |
|---|---|
| Nombre de tables | Conforme au script SQL |
| Absence d'erreur | Aucun message d'erreur SQL affiché |
| Données de test | Présence de données dans les tables principales |

## 5. Configuration applicative

### 5.1 Paramétrage de la connexion à la base de données

Ouvrir le fichier `config/database.php` et vérifier/adapter les paramètres suivants :

| Paramètre | Valeur type | Description |
|---|---|---|
| Hôte | `localhost` | Adresse du serveur de base de données |
| Nom de la base | `ppe_1` | Nom de la base créée à l'étape précédente |
| Utilisateur | `root` | Compte MySQL (par défaut sous WAMP) |
| Mot de passe | *(vide)* | Mot de passe associé (vide par défaut sous WAMP) |
| Port | `3306` | Port MySQL (par défaut) |

### 5.2 Contrôle de cohérence

S'assurer que :
- Le nom de la base dans `database.php` correspond exactement à celui créé dans phpMyAdmin.
- L'utilisateur dispose des droits de lecture et d'écriture sur la base.
- Le service MySQL est actif au moment du test.

## 6. Démarrage de l'application

| Étape | Action | Vérification |
|:---:|---|---|
| 1 | Lancer WAMP via le raccourci bureau. | L'icône WAMP passe au vert dans la barre des tâches. |
| 2 | Vérifier que les services Apache et MySQL sont actifs. | Clic gauche sur l'icône WAMP → les deux services indiquent « Running ». |
| 3 | Ouvrir le navigateur et saisir l'URL de l'application. | La page d'accueil s'affiche correctement. |

```
http://localhost/ppe_1/public/
```

## 7. Vérification post-installation

### 7.1 Grille de tests obligatoires

| N° | Test | Résultat attendu | Validé |
|:---:|---|---|:---:|
| T-01 | Ouverture de la page d'accueil | Affichage sans erreur | ☐ |
| T-02 | Accès à la page de connexion | Formulaire affiché | ☐ |
| T-03 | Accès à la page d'inscription | Formulaire affiché | ☐ |
| T-04 | Chargement de l'agenda | Calendrier avec événements | ☐ |
| T-05 | Ouverture des détails d'un match | Fiche détaillée affichée | ☐ |
| T-06 | Connexion avec un compte existant | Redirection vers espace connecté | ☐ |

### 7.2 Critère de validation globale

> L'installation est considérée comme **validée** lorsque l'ensemble des tests ci-dessus est passé avec succès, sans erreur bloquante.

## 8. Résolution des incidents

### 8.1 Erreur de connexion à la base de données

| Élément | Détail |
|---|---|
| **Symptôme** | Message d'erreur PDO, « base introuvable » ou page blanche. |
| **Causes possibles** | Identifiants incorrects dans `config/database.php`, service MySQL arrêté, base non créée. |
| **Actions correctives** | 1. Vérifier les paramètres dans `database.php`. 2. S'assurer que MySQL est actif (icône WAMP verte). 3. Confirmer l'existence de la base dans phpMyAdmin. |

### 8.2 Erreur 404 — Page non trouvée

| Élément | Détail |
|---|---|
| **Symptôme** | Le navigateur affiche une erreur 404. |
| **Causes possibles** | Nom du dossier incorrect, URL mal saisie, fichier `index.php` absent. |
| **Actions correctives** | 1. Vérifier que le dossier `ppe_1` est bien situé sous `c:/wamp64/www/`. 2. Contrôler l'URL saisie. 3. Vérifier la présence de `public/index.php`. |

### 8.3 Page blanche sans message d'erreur

| Élément | Détail |
|---|---|
| **Symptôme** | Aucun contenu HTML affiché. |
| **Causes possibles** | Erreur de syntaxe PHP, version PHP incompatible, affichage des erreurs désactivé. |
| **Actions correctives** | 1. Consulter les logs Apache : `c:/wamp64/logs/apache_error.log`. 2. Consulter les logs PHP : `c:/wamp64/logs/php_error.log`. 3. Activer temporairement `display_errors` dans `php.ini` pour diagnostic. |

## 9. Procédure de mise à jour

| Étape | Action |
|:---:|---|
| 1 | Sauvegarder l'intégralité des fichiers applicatifs. |
| 2 | Exporter la base de données via phpMyAdmin (format SQL). |
| 3 | Remplacer les fichiers sources par la nouvelle version. |
| 4 | Exécuter les scripts SQL de migration si fournis. |
| 5 | Relancer la grille de tests post-installation (§ 7.1). |

> **Avertissement :** Ne jamais appliquer une mise à jour sans avoir effectué une sauvegarde préalable complète.

## 10. Annexes

### 10.1 Chemins de référence

| Élément | Chemin |
|---|---|
| Racine web WAMP | `c:/wamp64/www/` |
| Répertoire projet | `c:/wamp64/www/ppe_1` |
| Point d'entrée | `c:/wamp64/www/ppe_1/public/index.php` |
| Logs Apache | `c:/wamp64/logs/apache_error.log` |
| Logs PHP | `c:/wamp64/logs/php_error.log` |

### 10.2 URL de référence

| Service | URL |
|---|---|
| Application PPE_1 | `http://localhost/ppe_1/public/` |
| phpMyAdmin | `http://localhost/phpmyadmin` |
| Page d'accueil WAMP | `http://localhost` |

---

<div align="center">

*Fin du document — Manuel d'Installation v2.0*

</div>
