<div align="center">

# MANUEL UTILISATEUR

### Application PPE_1 — Gestion d'activités sportives

</div>

---

| | |
|---|---|
| **Projet** | PPE_1 |
| **Document** | Manuel utilisateur |
| **Version** | 2.0 |
| **Date** | 14/04/2026 |
| **Destinataires** | Utilisateurs finaux (joueur, coach, administrateur) |
| **Confidentialité** | Usage interne au projet |

---

## Sommaire

1. [Introduction](#1-introduction)
2. [Objectifs du document](#2-objectifs-du-document)
3. [Prérequis](#3-prérequis)
4. [Accès à l'application](#4-accès-à-lapplication)
5. [Présentation de l'interface](#5-présentation-de-linterface)
6. [Procédures fonctionnelles](#6-procédures-fonctionnelles)
7. [Règles d'usage et bonnes pratiques](#7-règles-dusage-et-bonnes-pratiques)
8. [Dépannage de premier niveau](#8-dépannage-de-premier-niveau)
9. [Contact et assistance](#9-contact-et-assistance)
10. [Glossaire](#10-glossaire)

---

## 1. Introduction

Le présent document constitue le guide d'utilisation de l'application **PPE_1**. Il a pour vocation d'accompagner chaque utilisateur dans la prise en main des fonctionnalités offertes par la plateforme de gestion d'activités sportives.

Ce manuel couvre l'ensemble des opérations accessibles selon le profil de l'utilisateur : consultation de l'agenda, gestion du compte, suivi des inscriptions et consultation des détails de matchs.

## 2. Objectifs du document

- Permettre une prise en main rapide et autonome de l'application.
- Décrire de manière détaillée chaque procédure fonctionnelle.
- Fournir les solutions de premier niveau en cas d'anomalie.
- Servir de référence pour les utilisateurs réguliers comme occasionnels.

## 3. Prérequis

| Élément | Exigence |
|---|---|
| Navigateur | Google Chrome, Mozilla Firefox ou Microsoft Edge (version récente) |
| Réseau | Accès au réseau hébergeant l'application |
| Compte | Disposer d'un identifiant et d'un mot de passe valides |

> **Remarque :** Les fonctionnalités de consultation publique (accueil, agenda) sont accessibles sans authentification. Les fonctions personnelles (compte, inscriptions) nécessitent une connexion préalable.

## 4. Accès à l'application

1. Lancer le navigateur web.
2. Saisir l'URL suivante dans la barre d'adresse :
   ```
   http://localhost/ppe_1/public/
   ```
3. La page d'accueil de l'application doit s'afficher.
4. Utiliser la barre de navigation située dans l'en-tête pour accéder aux différentes sections.

## 5. Présentation de l'interface

| Section | Description | Accès |
|---|---|---|
| **Accueil** | Vue d'ensemble de la plateforme, accès rapide aux rubriques principales | Public |
| **Agenda** | Calendrier interactif des matchs et événements sportifs planifiés | Public |
| **Connexion** | Formulaire d'authentification de l'utilisateur | Public |
| **Inscription** | Formulaire de création de compte utilisateur | Public |
| **Compte** | Consultation et modification des informations personnelles | Connecté |
| **Mes inscriptions** | Liste des matchs auxquels l'utilisateur est inscrit | Connecté |
| **Pages sports** | Navigation thématique par discipline sportive | Public |

## 6. Procédures fonctionnelles

### 6.1 Créer un compte utilisateur

| Étape | Action |
|:---:|---|
| 1 | Accéder à la page **Inscription** depuis le menu de navigation. |
| 2 | Renseigner l'ensemble des champs obligatoires du formulaire (nom, prénom, identifiant, mot de passe, etc.). |
| 3 | Vérifier l'exactitude des informations saisies. |
| 4 | Cliquer sur le bouton **Valider**. |

> **Résultat attendu :** Le compte est créé en base de données. L'utilisateur peut désormais se connecter avec ses identifiants.

### 6.2 Se connecter

| Étape | Action |
|:---:|---|
| 1 | Accéder à la page **Connexion**. |
| 2 | Saisir l'identifiant et le mot de passe. |
| 3 | Cliquer sur **Se connecter**. |

> **Résultat attendu :** Redirection vers l'espace connecté. Les fonctionnalités personnelles deviennent accessibles.

### 6.3 Consulter l'agenda

| Étape | Action |
|:---:|---|
| 1 | Ouvrir la page **Agenda**. |
| 2 | Naviguer entre les périodes à l'aide des boutons **Précédent**, **Suivant** et **Aujourd'hui**. |
| 3 | Cliquer sur un événement pour en afficher les informations détaillées. |

> **Résultat attendu :** Les matchs planifiés s'affichent sous forme de calendrier interactif avec leurs dates et intitulés.

### 6.4 Consulter les détails d'un match

| Étape | Action |
|:---:|---|
| 1 | Sélectionner un match depuis l'agenda ou une page sport. |
| 2 | Consulter la fiche détaillée affichant : sport, lieu, date, horaire et liste des participants. |

> **Résultat attendu :** L'utilisateur dispose de toutes les informations nécessaires pour décider de sa participation.

### 6.5 Gérer son compte

| Étape | Action |
|:---:|---|
| 1 | Accéder à la page **Compte** (connexion requise). |
| 2 | Consulter ou modifier les informations personnelles autorisées. |
| 3 | Cliquer sur **Enregistrer** pour sauvegarder les modifications. |

> **Résultat attendu :** Les données mises à jour sont immédiatement reflétées dans le profil utilisateur.

### 6.6 Consulter ses inscriptions

| Étape | Action |
|:---:|---|
| 1 | Accéder à la page **Mes inscriptions** (connexion requise). |
| 2 | Parcourir la liste des matchs auxquels l'utilisateur est inscrit. |
| 3 | Vérifier le statut de chaque inscription. |

> **Résultat attendu :** L'historique complet des inscriptions actives est affiché.

### 6.7 Se déconnecter

| Étape | Action |
|:---:|---|
| 1 | Cliquer sur **Déconnexion** dans le menu de navigation. |
| 2 | Confirmer le retour à la page publique. |

> **Résultat attendu :** La session est clôturée. Les fonctionnalités réservées ne sont plus accessibles.

## 7. Règles d'usage et bonnes pratiques

- **Mot de passe :** choisir un mot de passe d'au moins 8 caractères mélangeant lettres, chiffres et caractères spéciaux.
- **Confidentialité :** ne jamais communiquer ses identifiants à un tiers.
- **Poste partagé :** toujours se déconnecter après utilisation sur un poste non personnel.
- **Actualisation :** consulter régulièrement l'agenda afin de disposer des informations les plus récentes.
- **Navigateur :** maintenir le navigateur à jour pour garantir la compatibilité avec l'application.

## 8. Dépannage de premier niveau

| Symptôme | Cause probable | Actions correctives |
|---|---|---|
| Impossible de se connecter | Identifiants incorrects | Vérifier la casse (majuscules/minuscules). Actualiser la page et réessayer. |
| Page blanche | Service Apache ou MySQL arrêté | Vérifier l'état des services dans WAMP. Relancer si nécessaire. |
| Agenda vide | Base de données non importée ou déconnectée | Vérifier l'import SQL. Contacter l'administrateur si le problème persiste. |
| Erreur 404 | URL incorrecte ou projet mal positionné | Vérifier l'URL saisie et l'emplacement du dossier projet sous `www/`. |
| Données non mises à jour | Cache navigateur | Effectuer un rechargement forcé (`Ctrl + F5`). |

## 9. Contact et assistance

En cas d'incident non résolu par les actions de dépannage ci-dessus, transmettre les informations suivantes à l'administrateur technique :

| Information | Détail à fournir |
|---|---|
| Page concernée | Nom ou URL de la page en erreur |
| Message d'erreur | Texte exact affiché à l'écran |
| Date et heure | Horodatage précis de l'incident |
| Compte utilisé | Identifiant du compte connecté |
| Navigateur | Nom et version du navigateur utilisé |

## 10. Glossaire

| Terme | Définition |
|---|---|
| **Compte** | Profil personnel permettant l'accès aux fonctionnalités réservées de l'application. |
| **Agenda** | Calendrier interactif affichant les matchs et événements sportifs planifiés. |
| **Inscription** | Action d'association d'un utilisateur à un match ou une activité sportive. |
| **Session** | Période durant laquelle un utilisateur est authentifié sur l'application. |
| **MVC** | Modèle-Vue-Contrôleur, architecture logicielle séparant données, interface et logique applicative. |
| **WAMP** | Environnement de développement web local sous Windows (Windows, Apache, MySQL, PHP). |

---

<div align="center">

*Fin du document — Manuel Utilisateur v2.0*

</div>
