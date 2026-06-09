<div align="center">

# MANUEL D'INSTALLATION

### Application PPE_1 — Gestion d'activités sportives

</div>

---

| | |
|---|---|
| **Projet** | PPE_1 |
| **Document** | Manuel d'installation |
| **Version** | 3.0 |
| **Date** | 20/04/2026 |
| **Destinataires** | Développeur, enseignant, administrateur technique |
| **Confidentialité** | Usage interne au projet |

---

## Sommaire

1. [Objet du document](#1-objet-du-document)
2. [Prérequis techniques](#2-prérequis-techniques)
3. [Installation des fichiers du projet](#3-installation-des-fichiers-du-projet)
4. [Initialisation de la base de données](#4-initialisation-de-la-base-de-données)
5. [Configuration applicative](#5-configuration-applicative)
6. [Configuration du serveur web](#6-configuration-du-serveur-web)
7. [Vérification post-installation](#7-vérification-post-installation)
8. [Résolution des incidents](#8-résolution-des-incidents)
9. [Procédure de mise à jour](#9-procédure-de-mise-à-jour)
10. [Annexes](#10-annexes)

---

## 1. Objet du document

Ce document décrit la procédure complète d'installation, de configuration et de vérification de l'application **PPE_1** sur un serveur Linux (Debian/Ubuntu) équipé d'Apache, PHP et MySQL/MariaDB. Il s'adresse à toute personne devant déployer l'application depuis les sources.

## 2. Prérequis techniques

### 2.1 Environnement matériel et logiciel

| Composant | Exigence |
|---|---|
| Système d'exploitation | Debian 11+ / Ubuntu 22.04+ (ou équivalent) |
| Serveur HTTP | Apache 2.4 |
| Langage | PHP 8.1 ou supérieur |
| Base de données | MySQL 8.0 ou MariaDB 10.6+ |
| Accès serveur | SSH avec droits sudo |
| Client de transfert | SCP, SFTP ou Git |
| Navigateur web | Chrome, Firefox ou Edge (version récente) |
| Espace disque | Minimum 100 Mo disponibles |

### 2.2 Extensions PHP requises

Les extensions PHP suivantes doivent être activées sur le serveur :

```
php-pdo
php-pdo-mysql
php-mbstring
php-json
```

Vérification et installation :

```bash
php -m | grep -E "pdo|mbstring|json"
sudo apt install php-pdo php-mysql php-mbstring -y
```

### 2.3 Ressources nécessaires

| Ressource | Localisation |
|---|---|
| Dossier du projet | `/var/www/html/ppe_1` |
| Script SQL d'initialisation | `public/ppe_1 (5).sql` |
| Fichier de configuration BDD | `config/database.php` |

## 3. Installation des fichiers du projet

### 3.1 Transfert des sources sur le serveur

**Option A — Via SCP (depuis le poste local) :**

```bash
scp -r ./ppe_1 utilisateur@adresse_serveur:/var/www/html/
```

**Option B — Via Git (sur le serveur) :**

```bash
cd /var/www/html
git clone <url_du_dépôt> ppe_1
```

**Option C — Via SFTP :** utiliser un client SFTP (FileZilla, WinSCP) pour déposer le dossier dans `/var/www/html/`.

### 3.2 Droits et propriétaire

Attribuer les fichiers au service web Apache :

```bash
sudo chown -R www-data:www-data /var/www/html/ppe_1
sudo chmod -R 755 /var/www/html/ppe_1
```

### 3.3 Contrôle d'intégrité

Vérifier la présence de l'arborescence suivante :

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

Vérifier l'existence des fichiers critiques :

| Fichier | Rôle |
|---|---|
| `public/index.php` | Point d'entrée de l'application |
| `config/database.php` | Configuration de la connexion à la base de données |
| `public/ppe_1 (5).sql` | Script de création et d'alimentation de la base |

> **Important :** Si l'un de ces fichiers est absent, l'installation ne pourra pas aboutir.

## 4. Initialisation de la base de données

### 4.1 Création de la base et de l'utilisateur

Se connecter au serveur MySQL en tant que root :

```bash
sudo mysql -u root -p
```

Puis exécuter les commandes suivantes :

```sql
CREATE DATABASE ppe_1 CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
CREATE USER 'ppe_user'@'localhost' IDENTIFIED BY 'MotDePasseSecurisé';
GRANT ALL PRIVILEGES ON ppe_1.* TO 'ppe_user'@'localhost';
FLUSH PRIVILEGES;
EXIT;
```

> **Sécurité :** Remplacer `'MotDePasseSecurisé'` par un mot de passe fort. Ne jamais utiliser `root` comme utilisateur applicatif en production.

### 4.2 Import du schéma et des données

```bash
mysql -u ppe_user -p ppe_1 < /var/www/html/ppe_1/public/ppe_1\ \(5\).sql
```

> **Résultat attendu :** La commande se termine sans erreur. Les tables sont créées dans la base `ppe_1`.

### 4.3 Vérification de l'import

```bash
mysql -u ppe_user -p -e "USE ppe_1; SHOW TABLES;"
```

| Vérification | Critère de succès |
|---|---|
| Liste des tables | Toutes les tables du script SQL sont présentes |
| Absence d'erreur | Aucun message d'erreur SQL affiché |
| Données de test | Présence de données dans les tables principales |

## 5. Configuration applicative

### 5.1 Paramétrage de la connexion à la base de données

Ouvrir le fichier `config/database.php` et adapter les paramètres :

```bash
sudo nano /var/www/html/ppe_1/config/database.php
```

| Paramètre | Valeur type | Description |
|---|---|---|
| Hôte | `localhost` | Adresse du serveur de base de données |
| Nom de la base | `ppe_1` | Nom de la base créée à l'étape précédente |
| Utilisateur | `ppe_user` | Compte MySQL dédié à l'application |
| Mot de passe | *(valeur choisie)* | Mot de passe défini lors de la création |
| Port | `3306` | Port MySQL (par défaut) |

### 5.2 Contrôle de cohérence

S'assurer que :
- Le nom de la base dans `database.php` correspond exactement à celui créé en § 4.1.
- L'utilisateur dispose des droits de lecture et d'écriture sur la base.
- Le service MySQL est actif : `sudo systemctl status mysql`.

## 6. Configuration du serveur web

### 6.1 Création d'un Virtual Host Apache

```bash
sudo nano /etc/apache2/sites-available/ppe_1.conf
```

Contenu du fichier :

```apache
<VirtualHost *:80>
    ServerName votre-domaine.fr
    DocumentRoot /var/www/html/ppe_1/public

    <Directory /var/www/html/ppe_1/public>
        AllowOverride All
        Require all granted
    </Directory>

    ErrorLog ${APACHE_LOG_DIR}/ppe_1_error.log
    CustomLog ${APACHE_LOG_DIR}/ppe_1_access.log combined
</VirtualHost>
```

### 6.2 Activation du site et du module rewrite

```bash
sudo a2ensite ppe_1.conf
sudo a2enmod rewrite
sudo systemctl reload apache2
```

### 6.3 Vérification des services

```bash
sudo systemctl status apache2
sudo systemctl status mysql
```

Les deux services doivent afficher **active (running)**.

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

L'URL d'accès à l'application est :

```
http://votre-domaine.fr/
```

### 7.2 Critère de validation globale

> L'installation est considérée comme **validée** lorsque l'ensemble des tests ci-dessus est passé avec succès, sans erreur bloquante.

## 8. Résolution des incidents

### 8.1 Erreur de connexion à la base de données

| Élément | Détail |
|---|---|
| **Symptôme** | Message d'erreur PDO, « base introuvable » ou page blanche. |
| **Causes possibles** | Identifiants incorrects dans `config/database.php`, service MySQL arrêté, base non créée. |
| **Actions correctives** | 1. Vérifier les paramètres dans `database.php`. 2. Vérifier l'état de MySQL : `sudo systemctl status mysql`. 3. Confirmer l'existence de la base : `mysql -u ppe_user -p -e "SHOW DATABASES;"`. |

### 8.2 Erreur 404 — Page non trouvée

| Élément | Détail |
|---|---|
| **Symptôme** | Le navigateur affiche une erreur 404. |
| **Causes possibles** | Virtual Host mal configuré, module rewrite non activé, `DocumentRoot` incorrect. |
| **Actions correctives** | 1. Vérifier le fichier `/etc/apache2/sites-available/ppe_1.conf`. 2. S'assurer que `a2enmod rewrite` a été exécuté. 3. Vérifier la présence de `public/index.php`. |

### 8.3 Erreur 403 — Accès interdit

| Élément | Détail |
|---|---|
| **Symptôme** | Le navigateur affiche une erreur 403 Forbidden. |
| **Causes possibles** | Droits insuffisants sur les fichiers ou le dossier. |
| **Actions correctives** | 1. Vérifier le propriétaire : `ls -la /var/www/html/ppe_1`. 2. Corriger : `sudo chown -R www-data:www-data /var/www/html/ppe_1`. |

### 8.4 Page blanche sans message d'erreur

| Élément | Détail |
|---|---|
| **Symptôme** | Aucun contenu HTML affiché. |
| **Causes possibles** | Erreur de syntaxe PHP, version PHP incompatible, affichage des erreurs désactivé. |
| **Actions correctives** | 1. Consulter les logs Apache : `sudo tail -f /var/log/apache2/ppe_1_error.log`. 2. Consulter les logs PHP : `sudo tail -f /var/log/php*`. 3. Activer temporairement `display_errors` dans `php.ini` pour diagnostic. |

## 9. Procédure de mise à jour

| Étape | Action |
|:---:|---|
| 1 | Sauvegarder l'intégralité des fichiers applicatifs sur le serveur. |
| 2 | Exporter la base de données : `mysqldump -u ppe_user -p ppe_1 > sauvegarde.sql`. |
| 3 | Transférer et déployer les nouveaux fichiers sources. |
| 4 | Réappliquer les droits : `sudo chown -R www-data:www-data /var/www/html/ppe_1`. |
| 5 | Exécuter les scripts SQL de migration si fournis. |
| 6 | Relancer la grille de tests post-installation (§ 7.1). |

> **Avertissement :** Ne jamais appliquer une mise à jour sans avoir effectué une sauvegarde préalable complète.

## 10. Annexes

### 10.1 Chemins de référence

| Élément | Chemin |
|---|---|
| Racine web | `/var/www/html/` |
| Répertoire projet | `/var/www/html/ppe_1` |
| Point d'entrée | `/var/www/html/ppe_1/public/index.php` |
| Configuration Apache | `/etc/apache2/sites-available/ppe_1.conf` |
| Logs Apache | `/var/log/apache2/ppe_1_error.log` |
| Logs PHP | `/var/log/php_errors.log` |

### 10.2 URL de référence

| Service | URL |
|---|---|
| Application PPE_1 | `http://votre-domaine.fr/` |
| Administration MySQL (optionnel) | `http://votre-domaine.fr/phpmyadmin` |

### 10.3 Commandes utiles

| Commande | Description |
|---|---|
| `sudo systemctl restart apache2` | Redémarrer Apache |
| `sudo systemctl restart mysql` | Redémarrer MySQL |
| `sudo apache2ctl configtest` | Vérifier la syntaxe de la configuration Apache |
| `sudo tail -f /var/log/apache2/ppe_1_error.log` | Afficher les logs Apache en temps réel |
| `mysqldump -u ppe_user -p ppe_1 > sauvegarde.sql` | Sauvegarder la base de données |

---

<div align="center">

*Fin du document — Manuel d'Installation v3.0*

</div>
