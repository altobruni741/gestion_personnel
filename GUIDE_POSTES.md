# 🚀 Guide de Démarrage - Nouvelle Hiérarchie Postes

Bienvenue! Voici comment utiliser votre application modernisée avec la nouvelle structure **Direction → Service → Poste → Personnel**.

## ⚡ Étapes de Mise en Place

### 1️⃣ Lancer la Migration des Postes

Avant de commencer, vous devez exécuter la migration pour créer la table `postes`:

```
http://localhost/gestion_personnel/migrate_postes.php
```

**Ce que fera cette migration:**
- ✅ Créer la table `postes` 
- ✅ Ajouter la colonne `poste_id` à la table personnel
- ✅ Importer les positions existantes comme postes
- ✅ Lier les employés à leurs nouveaux postes
- ⚠️ Aucune donnée ne sera supprimée

**Durée:** < 1 seconde  
**Statut:** Une seule exécution (protégée par un fichier de flag)

### 2️⃣ Accéder aux Pages de Gestion

Une fois la migration terminée, les nouvelles pages sont disponibles:

| Page | URL | Description |
|------|-----|-------------|
| **Directions** | `/index.php?page=directions` | Gérer les directions |
| **Services** | `/index.php?page=services` | Gérer les services |
| **Postes** (NEW) | `/index.php?page=poste` | Gérer les postes |
| **Personnel** | `/index.php?page=personnel` | Gérer les employés |

## 📚 Cas d'Usage Courants

### Cas 1: Créer une nouvelle structure organisationnelle

**Exemple:** Vous créez une nouvelle équipe "Développement Web"

```
1. Direction: Direction Technique
   ↓
2. Service: Service Développement Web
   ↓
3. Postes: 
   - Lead Developer
   - Developer Senior
   - Developer Junior
   ↓
4. Personnel: Assignez les employés à chaque poste
```

**Étapes:**
1. Allez dans "Directions" → "+ Ajouter" → "Direction Technique"
2. Allez dans "Services" → "+ Ajouter" → "Service Développement Web" (sélectionnez Direction Technique)
3. Allez dans "Postes" → "+ Ajouter" → Créez les 3 postes
4. Allez dans "Personnel" → Assignez vos développeurs aux postes

### Cas 2: Identifier les postes vacants

**Besoin:** Savoir quels postes ne sont pas pourvus

**Solution:**
1. Allez dans "Postes"
2. Regardez la colonne "Personnel" 
3. Les postes avec "0 employé" sont vacants
4. Cliquez sur le poste pour voir ses détails et ajouter quelqu'un

### Cas 3: Voir tous les employés d'une équipe

**Besoin:** Lister tous les employés du "Service Finances"

**Solution 1 - Via la page Personnel:**
1. Allez dans "Personnel"
2. Filtrez par "Service: Service Finances"
3. Exportez en CSV si nécessaire

**Solution 2 - Via la page Services:**
1. Allez dans "Services"
2. Cliquez sur "Service Finances"
3. Voyez tous les postes et employés

### Cas 4: Promouvoir un employé (changer de poste)

**Besoin:** Passer un "Developer Junior" à "Developer Senior"

**Solution:**
1. Allez dans "Personnel"
2. Cliquez sur l'employé
3. Cliquez "Modifier"
4. Changez le "Poste" de Junior à Senior
5. Sauvegardez

### Cas 5: Générer un rapport

**Besoin:** Exporter tous les employés actifs avec leurs postes

**Solution:**
1. Allez dans "Personnel"
2. Filtrez par "Statut: Actif"
3. Cliquez "Exporter CSV"
4. Ouvrez dans Excel/Calc

## 🎯 Structure Recommandée

Voici une structure organisationnelle suggérée:

```
DIRECTION GÉNÉRALE
├── Secrétariat
│   ├── Secrétaire de Direction
│   └── Assistant Administratif
├── Direction Administrative
│   ├── Responsable Admin
│   └── Chargé Admin
└── Ressources Humaines
    ├── Responsable RH
    ├── Chargé de Recrutement
    └── Gestionnaire Paie

DIRECTION OPÉRATIONNELLE
├── Production
│   ├── Chef de Production
│   ├── Superviseur
│   └── Ouvrier Spécialisé
├── Logistique
│   ├── Responsable Logistique
│   └── Logisticien
└── Contrôle Qualité
    ├── Responsable QA
    └── Inspecteur QA

DIRECTION COMMERCIALE
├── Ventes
│   ├── Responsable Ventes
│   └── Commercial
├── Marketing
│   ├── Responsable Marketing
│   └── Assistant Marketing
└── Service Client
    ├── Responsable Client
    └── Agent Client
```

## 🔧 Opérations Avancées

### Modifier en masse les postes d'un service

Vous pouvez filtrer tous les employés d'un service et les modifier en cascade:

1. Allez dans "Personnel"
2. Filtrez par "Service: [Service choisi]"
3. Modifiez chaque employé individuellement (actuellement)
4. *(Fonctionnalité édition en masse à venir)*

### Voir les statistiques par direction

1. Allez dans "Directions"
2. Cliquez sur une direction pour voir ses postes et effectifs

### Auditer les modifications

Chaque enregistrement a `created_at` et `updated_at`:

1. Allez dans "Personnel" 
2. Cliquez sur un employé
3. Voyez les dates en bas de page

## ❓ FAQ

**Q: Que se passe-t-il si je supprime un service?**  
R: Les postes du service sont supprimés, mais les employés ne sont pas supprimés (poste_id devient NULL).

**Q: Peux-je avoir un poste vide?**  
R: Oui! C'est normal pour les postes en attente de pourvoiement.

**Q: Peux-je changer le nom d'un poste?**  
R: Oui, allez dans "Postes" et cliquez "Modifier".

**Q: Comment exporter avec la hiérarchie complète?**  
R: Allez dans "Personnel", filtrez et cliquez "Exporter CSV". Toutes les colonnes incluent la hiérarchie.

**Q: La migration va supprimer mes données?**  
R: Non! La migration:
- ✅ Crée de nouvelles tables/colonnes
- ✅ Importe les données existantes
- ❌ Ne supprime rien
- ❌ Ne modifie rien d'existant

## 🆘 Troubleshooting

**Problème: La page "Postes" ne s'affiche pas**  
*Solution:* Assurez-vous que `migrate_postes.php` a été exécuté jusqu'au bout.

**Problème: Les employés n'ont pas de poste assigné**  
*Solution:* C'est normal si vous créez manuellement des postes. Allez dans "Personnel" et assignez-les.

**Problème: Erreur lors de la suppression d'un poste**  
*Solution:* Vérifiez qu'aucun employé n'est assigné au poste.

## 📞 Support

Pour toute question, consultez:
- 📖 [HIERARCHIE.md](HIERARCHIE.md) - Documentation technique complète
- 📋 [README.md](README.md) - Guide général de l'application

---

**Vous êtes maintenant prêt!** 🎉 Commencez par exécuter la migration puis explorez les pages de gestion.
