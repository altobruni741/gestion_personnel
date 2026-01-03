# 🎯 Gestion de Personnel - Application Professionnelle

Une application web complète et professionnelle pour gérer votre personnel, vos services, directions et **postes** avec une interface moderne, responsive et chargée de fonctionnalités avancées.

## ✨ Fonctionnalités Principales

### 🏢 Hiérarchie Organisationnelle (NEW)
- **Direction → Service → Poste → Personnel**
- Gestion complète des postes par service
- Vue détaillée des effectifs par poste
- Identification des postes vacants
- Statistiques par niveau hiérarchique
- Filtrage granulaire par structure

### 👥 Gestion Complète du Personnel
- **Champs détaillés**: Prénom, nom, email, téléphone, poste, statut
- **Informations d'emploi**: Date d'embauche, salaire, notes
- **Statuts variés**: Actif, Inactif, En Congé, Retraité
- **Organisation**: Association à un poste, service et direction
- **Historique**: Timestamps de création et modification

### 🔍 Recherche et Filtrage Avancé
- **Recherche multi-champs**: Nom, prénom, email, position
- **Filtres par hiérarchie**: Direction → Service → Poste
- **Filtres par statut**: Actif, Inactif, En Congé, Retraité
- **Combinaison de filtres**: Tous les filtres fonctionnent ensemble
- **Recherche en temps réel**: Résultats instantanés

### 📊 Statistiques et Rapports
- **Statistiques par poste**: Effectifs, statuts, taux d'occupation
- **Statistiques par service**: Total personnel et postes
- **Statistiques par direction**: Vue d'ensemble complète
- **Export CSV**: Exportez toutes les données filtrées

### 💾 Export et Données
- **Export CSV complet**: Prénom, Nom, Email, Téléphone, Poste, Statut, Date d'embauche, Salaire, Direction, Service
- **Respect des filtres**: L'export inclut uniquement les résultats filtrés
- **Format standard**: Compatible avec Excel et autres tableurs

### 🛡️ Validation et Sécurité Avancée
- **Validation email**: Vérification du format d'email
- **Validation téléphone**: Vérification du format du téléphone
- **Validation hiérarchie**: Vérification des dépendances
- **Messages d'erreur clairs**: Feedback utilisateur professionnel
- **Gestion d'erreurs robuste**: Logging et pages d'erreur personnalisées
- **Protection XSS**: Fonction `h()` pour sécuriser toutes les sorties
- **Protection SQL**: PDO avec requêtes paramétrées

### 🎨 Interface Utilisateur
- **Design moderne**: Tailwind CSS avec composants premium
- **Mode sombre complet**: Support Dark mode avec persistance
- **Responsive design**: Mobile, tablette, desktop
- **Navigation intuitive**: Menu sticky et mobile-friendly
- **Icônes SVG**: Visuels modernes et cohérents
- **Animations fluides**: Transitions et effets visuels

### 📱 Pages Détaillées
- **Vue d'un employé**: Affiche tous les détails dans une page dédiée
- **Vue d'un poste**: Affiche les employés assignés et statistiques
- **Formulaires complets**: Formulaires professionnels avec validation
- **Tableaux modernes**: Listes avec actions rapides
- **Cartes statistiques**: Affichage visuel des KPIs

## 🚀 Fonctionnalités Professionnelles

### Organisation et Gestion
- Gestion hiérarchique: Directions → Services → Personnel
- Support complet des rôles et statuts professionnels
- Gestion de la paie avec salaires
- Notes et remarques pour chaque employé

### Intégrations
- Historique des modifications (created_at, updated_at)
- Logging complet des actions
- Export de données pour analyse externe
- Support des formats standards (CSV)

## 📋 Structure Améliorée

### Base de Données Enrichie
```sql
personnel (
  - id, firstname, lastname (identité)
  - email, phone (contact)
  - position, status (emploi)
  - hire_date, salary (rémunération)
  - notes (remarques)
  - service_id, direction_id (organisation)
  - created_at, updated_at (suivi)
)
```

### Fonctionnalités de Recherche
- Recherche globale (nom, email, position)
- Filtres: statut, direction, service
- Combinaison de filtres
- Réinitialisation facile

## 🎯 Utilisation

### Gestion Avancée du Personnel
1. **Ajouter un employé**: Cliquez sur "Ajouter un employé"
2. **Compléter le formulaire**: Tous les champs détaillés
3. **Consulter les détails**: Cliquez sur "Voir les détails" pour une vue complète
4. **Modifier**: Mettez à jour les informations
5. **Filtrer**: Utilisez les filtres pour trouver rapidement
6. **Exporter**: Téléchargez les données en CSV

### Recherche et Filtrage
- Tapez un nom dans "Recherche" pour chercher
- Sélectionnez un statut pour filtrer par statut
- Choisissez une direction pour limiter aux employés d'une direction
- Choisissez un service pour limiter aux employés d'un service
- Cliquez "Filtrer" pour appliquer tous les filtres
- Cliquez "Réinitialiser" pour voir tous les employés

## 🌓 Mode Sombre
Cliquez sur l'icône lune/soleil dans la navigation. Votre préférence est sauvegardée localement.

## 📊 Rapports et Statistiques
- **Dashboard**: Affiche les statistiques clés
- **Compteurs**: Employés actifs, total, directions, services
- **Export**: Téléchargez les données avec les filtres appliqués

## 🔒 Sécurité
- Validation côté serveur complète
- Échappement HTML de toutes les sorties
- Protection contre les injections SQL (PDO paramétré)
- Protection contre les XSS
- Gestion des sessions
- Logging des actions pour l'audit

## 🛠️ Configuration

### Installation
1. Créez une base de données MySQL: `gestion_personnel`
2. Importez `sql/create_tables.sql`
3. Modifiez `config/db.php` selon votre environnement
4. Accédez à `http://localhost/gestion_personnel`

### Configuration BD (config/db.php)
```php
$db_host = '127.0.0.1';
$db_name = 'gestion_personnel';
$db_user = 'root';
$db_pass = '';
```

## 🎨 Personnalisation
- **Styles**: `assets/style.css`
- **Layout**: `views/layout/header.php` et `footer.php`
- **Couleurs**: Modifiables facilement via Tailwind CSS

## 📝 Notes Techniques
- **PHP**: 7.4+ (POO moderne)
- **MySQL**: 5.7+
- **CSS**: Tailwind CSS (CDN) + CSS personnalisé
- **Architecture**: MVC (Models, Views, Controllers)
- **Aucune dépendance externe**: Fonctionne avec PHP vanilla

## 📈 Fonctionnalités Futures
- Gestion des congés et absences
- Historique des modifications détaillé
- Gestion des compétences et formations
- Rapports avancés (PDF)
- Graphiques et visualisations
- Gestion multi-utilisateurs avec permissions

## 🤝 Support
Pour des questions ou des améliorations, consultez le code source commenté ou modifiez directement les fichiers.
