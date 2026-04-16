<div align="center">

# MANUEL TECHNIQUE

### Application PPE_1 — Gestion d'activités sportives

</div>

---

| | |
|---|---|
| **Projet** | PPE_1 |
| **Document** | Manuel technique |
| **Version** | 2.0 |
| **Date** | 14/04/2026 |
| **Destinataires** | Développeurs, mainteneurs, évaluateurs techniques |
| **Confidentialité** | Usage interne au projet |

---

## Sommaire

1. [Objet du document](#1-objet-du-document)
2. [Architecture générale](#2-architecture-générale)
3. [Arborescence du projet](#3-arborescence-du-projet)
4. [Cycle de traitement d'une requête](#4-cycle-de-traitement-dune-requête)
5. [Inventaire des composants](#5-inventaire-des-composants)
6. [Base de données](#6-base-de-données)
7. [Couche Frontend](#7-couche-frontend)
8. [Sécurité applicative](#8-sécurité-applicative)
9. [Normes de développement](#9-normes-de-développement)
10. [Procédure d'ajout d'une fonctionnalité](#10-procédure-dajout-dune-fonctionnalité)
11. [Stratégie de tests](#11-stratégie-de-tests)
12. [Performance et qualité](#12-performance-et-qualité)
13. [Gestion des incidents techniques](#13-gestion-des-incidents-techniques)
14. [Évolutions envisageables](#14-évolutions-envisageables)

---

## 1. Objet du document

Ce document fournit une description technique complète de l'application **PPE_1**. Il détaille l'architecture logicielle, l'organisation du code source, les composants applicatifs, les règles de développement et les procédures de maintenance.

Il constitue la référence technique pour toute intervention de développement, de correction ou d'évolution sur le projet.

## 2. Architecture générale

### 2.1 Pattern architectural

L'application repose sur le pattern **Modèle-Vue-Contrôleur (MVC)** structuré en trois couches distinctes :

```
┌─────────────────────────────────────────────┐
│                  CLIENT                     │
│            (Navigateur web)                 │
└──────────────────┬──────────────────────────┘
                   │ Requête HTTP
                   ▼
┌─────────────────────────────────────────────┐
│          CONTRÔLEUR (Controller)            │
│   Réception, routage, orchestration         │
└──────┬────────────────────────┬─────────────┘
       │                        │
       ▼                        ▼
┌──────────────┐     ┌─────────────────────┐
│   MODÈLE     │     │       VUE           │
│  (Modele)    │     │      (Vue)          │
│ Accès BDD    │     │  Rendu HTML/PHP     │
│ Logique      │     │  Interface          │
│ métier       │     │  utilisateur        │
└──────────────┘     └─────────────────────┘
```

### 2.2 Principes directeurs

| Principe | Application dans le projet |
|---|---|
| Séparation des responsabilités | Chaque couche a un rôle unique et ne déborde pas sur les autres. |
| Point d'entrée unique | Toutes les requêtes passent par `public/index.php`. |
| Centralisation de la configuration | La connexion BDD est définie dans un fichier unique (`config/database.php`). |
| Réutilisabilité | Les vues partielles (`vue/partial/`) sont partagées entre les pages. |

## 3. Arborescence du projet

```
ppe_1/
├── app/
│   ├── controller/          # Contrôleurs métier
│   │   ├── controllerAccueil.php
│   │   ├── controllerAgenda.php
│   │   ├── controllerCompte.php
│   │   ├── controllerConnexion.php
│   │   ├── controllerDeconnexion.php
│   │   ├── controllerInscription.php
│   │   ├── controllerMatchDetails.php
│   │   ├── controllerMesInscriptions.php
│   │   └── controllerPagesSports.php
│   ├── modele/              # Modèles d'accès aux données
│   │   ├── admin.php
│   │   ├── coach.php
│   │   ├── favoris.php
│   │   ├── joueur.php
│   │   ├── lieu.php
│   │   ├── match.php
│   │   ├── participe.php
│   │   ├── sport.php
│   │   └── utilisateur.php
│   └── vue/                 # Vues (rendu HTML)
│       ├── accueil.php
│       ├── agenda.php
│       ├── compte.php
│       ├── connexion.php
│       ├── inscription.php
│       ├── match_details.php
│       ├── mes_inscriptions.php
│       ├── pageSports.php
│       └── partial/
│           └── header.php
├── config/
│   ├── database.php         # Configuration connexion BDD
│   ├── compte.js            # Script JS page compte
│   ├── tabs.js              # Script JS onglets
│   └── pico.css             # Feuille de style
├── public/
│   ├── index.php            # Point d'entrée unique
│   ├── ppe_1 (5).sql        # Script SQL d'initialisation
│   └── fullcalendar/        # Librairie calendrier (assets locaux)
└── themes/
    └── simple/
        └── template.php     # Gabarit de thème
```

## 4. Cycle de traitement d'une requête

| Étape | Composant | Description |
|:---:|---|---|
| 1 | `public/index.php` | Réception de la requête HTTP entrante. |
| 2 | Routeur applicatif | Identification de la page ou de l'action demandée via les paramètres GET/POST. |
| 3 | Contrôleur | Exécution de la logique métier associée à l'action. |
| 4 | Modèle(s) | Interrogation de la base de données, récupération ou persistance des données. |
| 5 | Contrôleur | Préparation des données destinées à la vue. |
| 6 | Vue | Production du rendu HTML final renvoyé au client. |

## 5. Inventaire des composants

### 5.1 Contrôleurs

| Fichier | Responsabilité | Vue associée |
|---|---|---|
| `controllerAccueil.php` | Affichage de la page d'accueil | `accueil.php` |
| `controllerAgenda.php` | Gestion de la page agenda | `agenda.php` |
| `controllerConnexion.php` | Authentification utilisateur | `connexion.php` |
| `controllerDeconnexion.php` | Clôture de session | *(redirection)* |
| `controllerInscription.php` | Création de compte utilisateur | `inscription.php` |
| `controllerCompte.php` | Consultation et gestion du compte | `compte.php` |
| `controllerMatchDetails.php` | Affichage des détails d'un match | `match_details.php` |
| `controllerMesInscriptions.php` | Suivi des inscriptions utilisateur | `mes_inscriptions.php` |
| `controllerPagesSports.php` | Navigation thématique par sport | `pageSports.php` |

### 5.2 Modèles

| Fichier | Entité métier | Description |
|---|---|---|
| `utilisateur.php` | Utilisateur | Données de base du compte utilisateur. |
| `joueur.php` | Joueur | Profil spécifique au rôle joueur. |
| `coach.php` | Coach | Profil spécifique au rôle coach. |
| `admin.php` | Administrateur | Profil spécifique au rôle administrateur. |
| `match.php` | Match | Informations et états des matchs. |
| `sport.php` | Sport | Données par discipline sportive. |
| `lieu.php` | Lieu | Informations de localisation des matchs. |
| `participe.php` | Participation | Relation d'inscription entre utilisateur et match. |
| `favoris.php` | Favori | Gestion des favoris utilisateur. |

### 5.3 Vues

| Fichier | Fonction |
|---|---|
| `accueil.php` | Page d'accueil publique. |
| `agenda.php` | Calendrier interactif des matchs. |
| `connexion.php` | Formulaire d'authentification. |
| `inscription.php` | Formulaire de création de compte. |
| `compte.php` | Consultation/modification du profil. |
| `match_details.php` | Fiche détaillée d'un match. |
| `mes_inscriptions.php` | Liste des inscriptions de l'utilisateur. |
| `pageSports.php` | Navigation par discipline sportive. |
| `partial/header.php` | En-tête commun à toutes les pages. |

## 6. Base de données

### 6.1 Spécifications techniques

| Paramètre | Valeur |
|---|---|
| SGBD | MySQL / MariaDB |
| Script d'initialisation | `public/ppe_1 (5).sql` |
| Interclassement | `utf8mb4_general_ci` |
| Connexion | Centralisée via `config/database.php` |

### 6.2 Règles d'accès aux données

| Règle | Justification |
|---|---|
| Requêtes préparées (PDO) | Prévention des injections SQL. |
| Centralisation de la connexion | Fichier unique de configuration, maintenance simplifiée. |
| Validation avant écriture | Intégrité des données garantie avant toute insertion ou mise à jour. |
| Encapsulation dans les modèles | Aucune requête SQL directe dans les contrôleurs ou les vues. |

## 7. Couche Frontend

### 7.1 Bibliothèques et ressources

| Ressource | Rôle | Localisation |
|---|---|---|
| **Pico CSS** | Framework CSS léger pour le style général | `config/pico.css` |
| **FullCalendar** | Rendu du calendrier interactif sur la page agenda | `public/fullcalendar/` |
| **tabs.js** | Gestion des onglets dans l'interface | `config/tabs.js` |
| **compte.js** | Comportements spécifiques à la page compte | `config/compte.js` |

### 7.2 Intégration

- Les assets FullCalendar sont hébergés **localement** (aucune dépendance CDN).
- Les scripts JavaScript sont chargés uniquement sur les pages qui en ont besoin.
- Le thème visuel est défini dans `themes/simple/template.php`.

## 8. Sécurité applicative

| Mesure | Mise en œuvre |
|---|---|
| Contrôle d'accès | Vérification de l'état de la session PHP avant l'accès aux pages réservées. |
| Protection SQL | Utilisation systématique de requêtes préparées via PDO. |
| Validation des entrées | Contrôle côté serveur de toutes les données issues des formulaires. |
| Gestion de session | Destruction complète de la session (`session_destroy()`) lors de la déconnexion. |
| Masquage des erreurs | Désactivation de `display_errors` en environnement de production. |
| Nettoyage des entrées | Échappement des données affichées pour prévenir les failles XSS. |

## 9. Normes de développement

### 9.1 Conventions de nommage

| Élément | Convention | Exemple |
|---|---|---|
| Contrôleur | `controller` + NomFonctionnel + `.php` | `controllerAgenda.php` |
| Modèle | Nom de l'entité métier en minuscules | `match.php` |
| Vue | Nom fonctionnel en snake_case | `match_details.php` |
| Vue partielle | Dossier `partial/` | `partial/header.php` |

### 9.2 Règles de codage

- Respecter strictement la séparation MVC : aucune requête SQL dans les vues, aucun HTML dans les modèles.
- Centraliser la connexion BDD dans `config/database.php`.
- Commenter les blocs de logique métier complexes.
- Nommer les variables de manière explicite et cohérente.

## 10. Procédure d'ajout d'une fonctionnalité

| Étape | Action | Livrable |
|:---:|---|---|
| 1 | Définir le besoin fonctionnel et évaluer l'impact technique. | Spécification courte. |
| 2 | Créer ou modifier le modèle correspondant. | Fichier modèle mis à jour. |
| 3 | Créer ou modifier le contrôleur. | Fichier contrôleur mis à jour. |
| 4 | Créer ou adapter la vue. | Fichier vue mis à jour. |
| 5 | Tester le flux complet (requête → réponse). | Résultats de test. |
| 6 | Mettre à jour la documentation technique. | Documentation actualisée. |

## 11. Stratégie de tests

| Type de test | Périmètre | Méthode |
|---|---|---|
| Test fonctionnel | Chaque page et chaque action utilisateur | Exécution manuelle dans le navigateur. |
| Test d'authentification | Connexion, déconnexion, contrôle d'accès | Vérification des redirections et restrictions. |
| Test d'intégrité BDD | Insertion, lecture, mise à jour des données | Vérification via phpMyAdmin et interface. |
| Test de non-régression | Fonctionnalités existantes après modification | Rejeu des tests fonctionnels précédents. |
| Test de robustesse | Formulaires et saisies | Envoi de données invalides ou vides. |

## 12. Performance et qualité

| Axe | Recommandation |
|---|---|
| Requêtes SQL | Optimiser les requêtes les plus fréquentes. Éviter les requêtes dans les boucles. |
| Contrôleurs | Limiter les traitements redondants. Mutualiser les appels modèle si possible. |
| Ressources front | Ne charger que les scripts et styles nécessaires à la page courante. |
| Logs | Suivre les erreurs via les logs serveur Apache et PHP pour détection proactive. |

## 13. Gestion des incidents techniques

| Étape | Action |
|:---:|---|
| 1 | **Identifier** le point de rupture : routeur, contrôleur, modèle, vue ou base de données. |
| 2 | **Reproduire** l'erreur dans un environnement stable et isolé. |
| 3 | **Diagnostiquer** à l'aide des logs serveur et des messages d'erreur PHP/SQL. |
| 4 | **Corriger** le composant défaillant. |
| 5 | **Valider** en rejouant les tests fonctionnels minimum. |
| 6 | **Documenter** la correction dans le suivi du projet. |

## 14. Évolutions envisageables

| Évolution | Bénéfice attendu |
|---|---|
| Mise en place d'un routeur explicite | Gestion plus claire et extensible des URL et des actions. |
| Ajout de tests automatisés (PHPUnit) | Détection précoce des régressions, fiabilité accrue. |
| Renforcement de la gestion des rôles | Contrôle d'accès plus fin selon le profil (joueur, coach, admin). |
| Exposition d'une API REST interne | Découplage front/back, préparation à une future interface mobile. |
| Migration vers un framework PHP | Gain de productivité et accès à un écosystème de composants éprouvés. |

---

<div align="center">

*Fin du document — Manuel Technique v2.0*

</div>
