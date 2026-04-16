<div align="center">

# CAHIER DES CHARGES

### Application PPE_1 — Gestion d'activités sportives

</div>

---

| | |
|---|---|
| **Projet** | PPE_1 |
| **Document** | Cahier des charges fonctionnel et technique |
| **Version** | 2.0 |
| **Date** | 14/04/2026 |
| **Cadre** | Projet pédagogique |
| **Confidentialité** | Usage interne au projet |

---

## Sommaire

1. [Présentation générale](#1-présentation-générale)
2. [Périmètre du projet](#2-périmètre-du-projet)
3. [Parties prenantes](#3-parties-prenantes)
4. [Exigences fonctionnelles](#4-exigences-fonctionnelles)
5. [Exigences non fonctionnelles](#5-exigences-non-fonctionnelles)
6. [Contraintes techniques](#6-contraintes-techniques)
7. [Sécurité et protection des données](#7-sécurité-et-protection-des-données)
8. [Livrables](#8-livrables)
9. [Planning prévisionnel](#9-planning-prévisionnel)
10. [Recette et critères d'acceptation](#10-recette-et-critères-dacceptation)
11. [Analyse des risques](#11-analyse-des-risques)

---

## 1. Présentation générale

### 1.1 Contexte du projet

Le projet **PPE_1** s'inscrit dans le cadre d'un projet pédagogique visant à concevoir et développer une application web de gestion d'activités sportives. La plateforme centralise les informations relatives aux matchs, propose un agenda interactif et permet la gestion des comptes utilisateurs ainsi que le suivi des inscriptions.

### 1.2 Finalité

Mettre à disposition une solution web fonctionnelle, maintenable et documentée permettant :

- la consultation centralisée des matchs et événements sportifs ;
- la gestion complète du cycle de vie des comptes utilisateurs ;
- le suivi des inscriptions aux activités ;
- l'organisation de l'information sportive par discipline.

### 1.3 Objectifs pédagogiques

- Concevoir et implémenter une architecture **Modèle-Vue-Contrôleur (MVC)**.
- Structurer un projet web PHP avec une séparation rigoureuse des responsabilités.
- Établir la liaison entre une interface web et une base de données relationnelle.
- Produire une documentation professionnelle couvrant l'intégralité du cycle de vie du projet.

## 2. Périmètre du projet

### 2.1 Fonctionnalités incluses

| Réf. | Fonctionnalité |
|---|---|
| F-01 | Inscription d'un nouvel utilisateur |
| F-02 | Connexion et déconnexion sécurisées |
| F-03 | Consultation de l'agenda des matchs |
| F-04 | Consultation des détails d'un match |
| F-05 | Gestion du compte utilisateur |
| F-06 | Consultation des inscriptions personnelles |
| F-07 | Navigation thématique par sport |

### 2.2 Exclusions explicites

Les éléments suivants sont **hors périmètre** de la version actuelle :

- Système de paiement en ligne.
- Application mobile native (iOS/Android).
- Notifications push en temps réel.
- API publique documentée pour intégration tierce.
- Messagerie interne entre utilisateurs.

## 3. Parties prenantes

| Rôle | Responsabilités |
|---|---|
| **Visiteur** | Consulte les pages publiques (accueil, agenda, pages sport). |
| **Utilisateur connecté** | Accède aux fonctions personnalisées (compte, inscriptions). |
| **Coach** | Consulte et encadre les matchs de sa discipline. |
| **Administrateur** | Supervise les données, garantit la cohérence fonctionnelle. |
| **Équipe projet** | Développe, teste, documente et livre l'application. |

## 4. Exigences fonctionnelles

### 4.1 Module Authentification

| Réf. | Exigence | Priorité |
|---|---|---|
| EF-01 | Le système doit proposer un formulaire d'inscription avec validation des champs obligatoires. | Haute |
| EF-02 | Le système doit vérifier l'unicité de l'identifiant lors de l'inscription. | Haute |
| EF-03 | Le système doit permettre la connexion via identifiant et mot de passe. | Haute |
| EF-04 | Le système doit permettre la déconnexion et la destruction complète de la session. | Haute |

### 4.2 Module Consultation sportive

| Réf. | Exigence | Priorité |
|---|---|---|
| EF-05 | Le système doit afficher un agenda interactif des matchs via FullCalendar. | Haute |
| EF-06 | Le système doit afficher une fiche détaillée pour chaque match (sport, lieu, date, participants). | Haute |
| EF-07 | Le système doit proposer une navigation par discipline sportive. | Moyenne |

### 4.3 Module Gestion personnelle

| Réf. | Exigence | Priorité |
|---|---|---|
| EF-08 | Le système doit afficher les informations du compte de l'utilisateur connecté. | Haute |
| EF-09 | Le système doit permettre la modification des données personnelles autorisées. | Moyenne |
| EF-10 | Le système doit afficher la liste des inscriptions associées à l'utilisateur. | Haute |

## 5. Exigences non fonctionnelles

| Réf. | Exigence | Critère mesurable |
|---|---|---|
| ENF-01 | Compatibilité navigateur | Chrome, Firefox, Edge (versions récentes) |
| ENF-02 | Performance | Temps de chargement < 2 secondes en environnement local |
| ENF-03 | Maintenabilité | Architecture MVC respectée, code structuré et lisible |
| ENF-04 | Sécurité des entrées | Validation serveur systématique des données de formulaire |
| ENF-05 | Persistance | Base de données relationnelle MySQL/MariaDB |
| ENF-06 | Ergonomie | Interface lisible, navigation cohérente et intuitive |

## 6. Contraintes techniques

| Composant | Technologie / Outil |
|---|---|
| Langage serveur | PHP |
| Serveur local | WAMP (Windows, Apache, MySQL, PHP) |
| Base de données | MySQL / MariaDB |
| Script d'initialisation | `public/ppe_1 (5).sql` |
| Calendrier | FullCalendar (assets locaux) |
| Feuille de style | Pico CSS |
| Organisation du code | MVC (`app/controller`, `app/modele`, `app/vue`) |

## 7. Sécurité et protection des données

| Mesure | Description |
|---|---|
| Authentification | Contrôle d'accès par session PHP pour les pages réservées. |
| Requêtes SQL | Utilisation de requêtes préparées (PDO) pour prévenir les injections SQL. |
| Validation | Contrôle côté serveur de toutes les entrées utilisateur. |
| Sessions | Destruction complète de la session lors de la déconnexion. |
| Exposition | Masquage des erreurs techniques en environnement de production. |

## 8. Livrables

| Réf. | Livrable | Format |
|---|---|---|
| L1 | Code source complet de l'application | PHP / HTML / JS / CSS |
| L2 | Base de données initiale | Script SQL |
| L3 | Manuel utilisateur | Markdown (.md) |
| L4 | Manuel d'installation | Markdown (.md) |
| L5 | Manuel technique | Markdown (.md) |
| L6 | Cahier des charges | Markdown (.md) |

## 9. Planning prévisionnel

| Phase | Description | Statut |
|---|---|---|
| Phase 1 | Analyse du besoin et conception | Terminée |
| Phase 2 | Développement des modules principaux | Terminée |
| Phase 3 | Intégration base de données et vues | Terminée |
| Phase 4 | Tests fonctionnels et corrections | En cours |
| Phase 5 | Rédaction et finalisation de la documentation | En cours |

## 10. Recette et critères d'acceptation

| Réf. | Critère | Validation |
|---|---|---|
| CA-01 | Les pages principales sont accessibles sans erreur bloquante. | ☐ |
| CA-02 | L'inscription crée un compte fonctionnel en base. | ☐ |
| CA-03 | La connexion et la déconnexion fonctionnent correctement. | ☐ |
| CA-04 | L'agenda affiche les événements enregistrés. | ☐ |
| CA-05 | Les détails d'un match sont consultables. | ☐ |
| CA-06 | La page « Mes inscriptions » affiche les données attendues. | ☐ |
| CA-07 | L'installation est reproductible à partir du manuel dédié. | ☐ |

## 11. Analyse des risques

| Réf. | Risque | Impact | Probabilité | Action préventive |
|---|---|---|---|---|
| R-01 | Mauvaise configuration de la base de données | Élevé | Moyenne | Documenter précisément la procédure d'installation. |
| R-02 | Incohérence entre modèle et vue après évolution | Moyen | Moyenne | Tester systématiquement chaque fonctionnalité après modification. |
| R-03 | Jeu de données de test insuffisant | Moyen | Faible | Maintenir un script SQL de données de test stable. |
| R-04 | Perte de données lors d'une mise à jour | Élevé | Faible | Exporter la base avant toute intervention. |

---

<div align="center">

*Fin du document — Cahier des Charges v2.0*

</div>
