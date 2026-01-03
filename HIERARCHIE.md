# Guide de la Hiérarchie Organisationnelle

## Structure: Direction → Service → Poste → Personnel

L'application est désormais organisée selon une hiérarchie robuste à 4 niveaux:

### 1. **Direction** 📊
- Niveau le plus haut de l'organisation
- Exemples: "Direction Générale", "Direction Administrative", etc.
- Contient plusieurs Services

### 2. **Service** 🏢
- Appartient à une Direction
- Exemples: "Service RH", "Service Finances", etc.
- Contient plusieurs Postes

### 3. **Poste** 💼
- Appartient à un Service
- Exemples: "Chef de Projet", "Responsable RH", "Comptable", etc.
- Peut être occupé par plusieurs employés

### 4. **Personnel** 👤
- Employé assigné à un Poste (optionnel)
- Peut aussi être rattaché directement au Service ou à la Direction
- Contient les infos: nom, email, téléphone, statut, salaire, etc.

## Avantages de cette Organisation

✅ **Hiérarchie claire** - Structure logique et intuitive  
✅ **Filtrage robuste** - Filtrer le personnel par Direction/Service/Poste  
✅ **Gestion des ressources** - Voir les postes vides, les sureffectifs  
✅ **Rapports détaillés** - Statistiques par niveau  
✅ **Scalabilité** - Support de structures complexes  

## Utilisation

### Créer une hiérarchie

1. **Créer une Direction** → Allez dans "Directions" → "+ Ajouter"
2. **Créer un Service** → Allez dans "Services" → Sélectionnez la Direction → "+ Ajouter"
3. **Créer un Poste** → Allez dans "Postes" → Sélectionnez Service et Direction → "+ Ajouter"
4. **Ajouter du Personnel** → Allez dans "Personnel" → Assignez à un Poste

### Filtrer le Personnel

Dans la page "Personnel":
- Filtrer par **Direction** - affiche tout le personnel de cette direction
- Filtrer par **Service** - affiche le personnel du service spécifique
- Filtrer par **Poste** - affiche les employés occupant ce poste
- Filtrer par **Statut** - Actif, En Congé, Inactif, Retraité

### Gérer les Postes

La page "Postes" permet de:
- 📋 Voir tous les postes et leur service
- 📊 Voir le nombre d'employés par poste
- 🚨 Identifier les postes vides
- ✏️ Modifier les informations du poste
- 👥 Voir les employés assignés au poste

## Exemples de Structure

```
Direction Administrative et Financière
├── Service des Finances
│   ├── Chef des Finances
│   ├── Comptable Senior
│   └── Comptable Junior
├── Service des Ressources Humaines
│   ├── Responsable RH
│   ├── Gestionnaire Paie
│   └── Chargé de Recrutement
└── Service de la Logistique
    ├── Responsable Logistique
    └── Logisticien

Direction Développement
├── Service Développement Web
│   ├── Lead Developer
│   ├── Developer Senior
│   └── Developer Junior
└── Service QA
    ├── Lead QA
    └── QA Tester
```

## Migration vers la Nouvelle Structure

Si vous aviez une structure sans "Postes" avant:

1. ✅ Les données existantes sont conservées
2. ⚙️ Un script de migration a créé automatiquement les Postes à partir de la colonne "position"
3. 📝 Vous pouvez maintenant utiliser la colonne `poste_id` pour des requêtes plus granulaires

## Champs de la Base de Données

### Table `directions`
```sql
id (INT) - ID unique
name (VARCHAR) - Nom de la direction
```

### Table `services`
```sql
id (INT) - ID unique
name (VARCHAR) - Nom du service
direction_id (INT FK) - Référence à la direction parent
```

### Table `postes` (NEW)
```sql
id (INT) - ID unique
name (VARCHAR) - Nom du poste
description (TEXT) - Description du poste
service_id (INT FK) - Référence au service parent
created_at (DATETIME) - Date de création
updated_at (DATETIME) - Date de modification
```

### Table `personnel`
```sql
id (INT) - ID unique
firstname (VARCHAR) - Prénom
lastname (VARCHAR) - Nom
email (VARCHAR) - Email unique
phone (VARCHAR) - Téléphone
position (VARCHAR) - Titre du poste (legacy)
status (ENUM) - Actif, Inactif, En Congé, Retraité
hire_date (DATE) - Date d'embauche
salary (DECIMAL) - Salaire
notes (TEXT) - Notes
service_id (INT FK) - Service associé
direction_id (INT FK) - Direction associée
poste_id (INT FK) - Poste occupé (NEW)
created_at (DATETIME) - Date de création
updated_at (DATETIME) - Date de modification
```

## Requêtes SQL Courantes

### Obtenir tous les employés d'une direction
```sql
SELECT p.* FROM personnel p
JOIN postes po ON p.poste_id = po.id
JOIN services s ON po.service_id = s.id
WHERE s.direction_id = ?
```

### Obtenir les employés d'un service
```sql
SELECT p.* FROM personnel p
JOIN postes po ON p.poste_id = po.id
WHERE po.service_id = ?
```

### Obtenir les postes vacants
```sql
SELECT po.* FROM postes po
LEFT JOIN personnel p ON po.id = p.poste_id
WHERE p.id IS NULL
```

### Statistiques par direction
```sql
SELECT d.name, COUNT(p.id) as count
FROM directions d
LEFT JOIN services s ON d.id = s.direction_id
LEFT JOIN postes po ON s.id = po.service_id
LEFT JOIN personnel p ON po.id = p.poste_id
WHERE p.status = 'Actif'
GROUP BY d.id
```

## Support et Maintenance

- ✅ Toutes les données existantes sont préservées
- ✅ Les migrations sont automatiques lors du premier accès
- ✅ La cascade DELETE protège l'intégrité des données
- ✅ Les indexes optimisent les performances

Pour réinitialiser une hiérarchie, consultez la page d'administration.
