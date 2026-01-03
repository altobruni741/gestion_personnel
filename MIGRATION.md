# 🔧 Résolution de l'Erreur 500

L'erreur 500 provient de la structure de la base de données qui n'a pas été mise à jour pour les nouvelles fonctionnalités.

## ✅ Solution

### Étape 1: Effectuer la Migration

1. **Accédez à l'URL suivante:**
   ```
   http://localhost/gestion_personnel/setup.php
   ```

2. **Cliquez sur "Lancer la migration"**
   - Le script ajoutera automatiquement les nouvelles colonnes
   - Cela ne supprimera pas vos données existantes
   - Cette opération est sûre et réversible

3. **Attendez la confirmation:**
   - Vous verrez un message "Migration terminée avec succès!"
   - Cliquez sur "Accéder à l'application" pour continuer

### Étape 2: Vérifiez que tout fonctionne

Accédez à la page personnel:
```
http://localhost/gestion_personnel/index.php?page=personnel
```

## 🔍 Ce qui a été Migré

Le script ajoute automatiquement à la table `personnel`:

### Champs de Contact
- `email` - Adresse email professionnelle
- `phone` - Numéro de téléphone

### Champs d'Emploi
- `position` - Titre du poste (existant, pas modifié)
- `status` - Statut (Actif, Inactif, En Congé, Retraité)
- `hire_date` - Date d'embauche
- `salary` - Salaire mensuel

### Champs Supplémentaires
- `notes` - Remarques et notes
- `created_at` - Date de création
- `updated_at` - Date de dernière modification

### Index de Performance
- Index sur `status`
- Index sur `service_id`
- Index sur `direction_id`

## 🛡️ Sécurité

- Les migrations ne s'exécutent qu'une seule fois
- Un fichier `.migration_done` empêche les exécutions répétées
- Toutes les données existantes sont préservées
- Vos employés existants gardent leurs informations

## ⚙️ Troubleshooting

Si vous avez toujours une erreur après la migration:

1. **Vérifiez que la migration s'est bien déroulée:**
   - Ouvrez phpMyAdmin
   - Allez à `gestion_personnel` → `personnel`
   - Vérifiez que les colonnes (email, phone, status, etc.) existent

2. **Vérifiez les permissions MySQL:**
   - L'utilisateur MySQL doit avoir la permission ALTER
   - Utilisateur par défaut XAMPP: `root` (pas de mot de passe)

3. **Videz le cache du navigateur:**
   - Appuyez sur Ctrl+Shift+Del (ou Cmd+Shift+Del sur Mac)
   - Sélectionnez "Cache" et "Supprimer"

4. **Redémarrez Apache et MySQL:**
   - Arrêtez XAMPP Control Panel
   - Redémarrez les services Apache et MySQL

## 📝 Notes

- Une seule migration suffit
- Les migrations ultérieures seront ignorées
- Pour réinitialiser: Supprimez le fichier `.migration_done` et relancez `setup.php`

**Besoin d'aide?** Vérifiez les logs dans `logs/app.log`
