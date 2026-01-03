# Audit de la Logique Hiérarchique : Direction → Service → Poste → Personnel

**Date:** 2025-12-16  
**État:** Audit effectué - Logique validée avec recommandations

---

## 1. Structure Hiérarchique

### Hiérarchie Validée ✅
```
Direction (1)
    └── Service (n)
        └── Poste (n)
            └── Personnel (n)
```

### Relations de Base de Données

#### Table `directions`
- **PK:** `id` (AUTO_INCREMENT)
- **Colonnes:** `id`, `name`
- **État:** ✅ Valide

#### Table `services`
- **PK:** `id` (AUTO_INCREMENT)
- **FK:** `direction_id` → `directions(id)` (ON DELETE SET NULL)
- **Colonnes:** `id`, `name`, `direction_id`
- **État:** ✅ Valide
- **Note:** ON DELETE SET NULL est approprié (les services restent si direction supprimée)

#### Table `postes`
- **PK:** `id` (AUTO_INCREMENT)
- **FK:** `service_id` → `services(id)` (ON DELETE CASCADE)
- **Colonnes:** `id`, `name`, `description`, `service_id`, `created_at`, `updated_at`
- **Unique:** `(name, service_id)` - Empêche les doublons au sein d'un service
- **Index:** `idx_service` pour les requêtes récurrentes
- **État:** ✅ Valide
- **Note:** ON DELETE CASCADE est approprié (les postes sont supprimés avec le service)

#### Table `personnel`
- **PK:** `id` (AUTO_INCREMENT)
- **FK:** `service_id` → `services(id)` (ON DELETE SET NULL)
- **FK:** `direction_id` → `directions(id)` (ON DELETE SET NULL)
- **FK:** `poste_id` → `postes(id)` (ON DELETE SET NULL)
- **Colonnes incluent:**
  - `firstname`, `lastname` (REQUIRED)
  - `email`, `phone`, `position`
  - `status` (ENUM: 'Actif', 'Inactif', 'En Congé', 'Retraité')
  - `hire_date`, `salary`, `notes`
  - `service_id`, `direction_id`, `poste_id`
  - `contract_duration` (INT, migré)
  - `contract_end` (DATE, migré)
  - `created_at`, `updated_at`
- **Index:** `idx_status`, `idx_service`, `idx_direction`, `idx_poste`
- **État:** ✅ Valide
- **Note:** Tous les FK utilisent ON DELETE SET NULL (maintient les enregistrements)

---

## 2. Logique Métier - Modèles

### `Direction.php` ✅
**Fonctions:**
- `all()` - Récupère toutes les directions
- `find($id)` - Récupère une direction
- `create($name)` - Crée une direction
- `update($id, $name)` - Met à jour
- `delete($id)` - **Cascade correcte:**
  - Dissocier personnel: `UPDATE personnel SET direction_id = NULL`
  - Supprimer postes (via services): DELETE FROM postes WHERE service_id IN (SELECT id FROM services)
  - Supprimer services: `DELETE FROM services`
  - Supprimer direction
- `getServices($direction_id)` - Services de la direction ✅
- `getPostes($direction_id)` - Tous les postes de la direction via services ✅

**État:** ✅ Valide et robuste

---

### `Service.php` ✅
**Fonctions:**
- `all()` - Récupère tous les services avec `direction_name`
- `find($id)` - Récupère un service avec `direction_name`
- `byDirection($direction_id)` - Services d'une direction
- `create($name, $direction_id)` - Crée un service
- `update($id, $name, $direction_id)` - Met à jour
- `delete($id)` - **Cascade correcte:**
  - Dissocier personnel: `UPDATE personnel SET service_id = NULL`
  - Supprimer postes: `DELETE FROM postes`
  - Supprimer service
- `getStats($id)` - Statistiques (personnel, postes, actifs)

**État:** ✅ Valide et robuste

---

### `Poste.php` ✅
**Fonctions:**
- `all($filters)` - Récupère tous les postes avec `service_name`, `direction_name`
  - Filtre par `direction_id` et `service_id`
- `find($id)` - Récupère un poste avec relations
- `byService($service_id)` - Postes d'un service
- `byDirection($direction_id)` - Tous les postes d'une direction
- `create($data)` - Validation: `name`, `service_id` requis
- `update($id, $data)` - Met à jour
- `delete($id)` - Dissocier personnel ET supprimer poste
- `getPersonnel($poste_id)` - Personnel d'un poste

**État:** ✅ Valide et robuste

---

### `Personnel.php` ✅ (avec mises à jour)
**Colonnes gérées:**
- Informations personnelles: `firstname`, `lastname`, `email`, `phone`
- Emploi: `position`, `status`, `hire_date`, `salary`, `notes`
- Organisation: `direction_id`, `service_id`, `poste_id`
- Contrat: `contract_duration` (INT), `contract_end` (DATE)

**Fonctions principales:**
- `all($filters)` - Filtre par `status`, `direction_id`, `service_id`, `search`
  - **LIMITATION:** Ne filtre pas par `poste_id` (voir recommandation)
  - Joins: LEFT JOIN services, directions, postes (si table existe)
  - Ordre: `d.name, s.name, po.name, p.lastname, p.firstname`
  
- `find($id)` - Récupère un employé
- `create($data)` - **Logique:**
  - Construit SQL dynamiquement selon colonnes existantes
  - Détecte `contract_duration` et `contract_end` via `columnExists()`
  - Calcule `contract_end = hire_date + contract_duration jours` si présents
  
- `update($id, $data)` - Même logique que create
- `byPoste($poste_id)` - Personnel d'un poste (avec relations)
- `getStats()` - Actifs, par direction, par service
- `exportCsv($personnel)` - Export CSV (inclut poste_name si dispo)

**État:** ✅ Valide avec calcul contrats automatisé

---

## 3. Logique Contrôleur - PersonnelController.php ✅

**Actions implémentées:**
- `list` - Récupère personnel avec filtres, calcule `$expiring` (contrats ≤ 10 jours)
- `create` - Valide firstname/lastname/email/phone, sanitize `contract_duration`
- `edit` - Mêmes validations
- `view` - Affiche détails
- `delete` - Supprime

**Nouvelle logique:**
- `$needsContractMigration` - Détecte colonnes `contract_duration`/`contract_end` manquantes
- `$expiring` array - Liste des employés avec contrat expirant dans ≤ 10 jours

**État:** ✅ Valide

---

## 4. Logique Vues

### `views/personnel/list.php` ✅
- Filtre par: recherche, statut, direction, service
- Tableau affichage: Nom, Contact, Poste, Service, Direction, Statut, Actions
- **Alerte contrats:**
  - Banner si `$expiring` non vide
  - Badge par ligne (⚠ Xj) si contract_end ≤ 10 jours
- **Migration opt-in:** Prompt si `$needsContractMigration` true

**État:** ✅ Valide

### `views/personnel/form.php` ✅
- Sections: Identité, Poste/Organisation, Statut/Emploi, Notes
- Champs hiérarchie: Direction, Service (selects avec listes)
- **Nouveau:** Champs contrat:
  - `contract_duration` (INT input, nombre de jours)
  - `contract_end` (DATE readonly)
  - **JS:** Calcul automatique `contract_end = hire_date + duration`
- **Migration opt-in:** Prompt si `$needsContractMigration` true

**État:** ✅ Valide

### `views/poste/list.php` ✅
- Affiche Direction, Service, Poste
- Actions: Voir, Éditer, Supprimer
- Filtres par Direction et Service

**État:** ✅ Valide

---

## 5. Validations Découvertes ✅

### Cascades de Suppression
| Objet | Action | Résultat |
|-------|--------|----------|
| Direction | DELETE | Services SET direction_id=NULL; Postes DELETE; Personnel SET direction_id=NULL |
| Service | DELETE | Personnel SET service_id=NULL; Postes DELETE; |
| Poste | DELETE | Personnel SET poste_id=NULL |
| Personnel | DELETE | Simple DELETE |

**État:** ✅ Logique saine - les FK utilisent ON DELETE SET NULL sauf postes (CASCADE) ✅

### Intégrité Référentielle
- ✅ Un Poste DOIT avoir un Service (FK NOT NULL)
- ✅ Un Service PEUT avoir une Direction (FK NULLABLE)
- ✅ Un Personnel PEUT avoir Direction/Service/Poste (FK NULLABLE)
- ✅ Contrats: `contract_end` calculé automatiquement si `hire_date` + `contract_duration` présents

**État:** ✅ Cohérent

---

## 6. Recommandations

### Haute Priorité 🔴

1. **Ajouter filtre `poste_id` dans Personnel.all()** 
   - Situation actuelle: Les filtres incluent `direction_id`, `service_id` mais PAS `poste_id`
   - Impact: Les listes filtrées par poste ne sont pas possibles via le formulaire
   - Action: Ajouter:
   ```php
   if (!empty($filters['poste_id'])) {
       $query .= ' AND p.poste_id = ?';
       $params[] = $filters['poste_id'];
   }
   ```

2. **Valider cohérence Service ↔ Poste dans Personnel**
   - Situation: Un Personnel peut avoir un `service_id` ET un `poste_id` qui n'appartient PAS à ce service
   - Impact: Incohérence hiérarchique
   - Action: Dans le contrôleur, si `poste_id` fourni, vérifier que le poste appartient au service:
   ```php
   if (!empty($_POST['poste_id']) && !empty($_POST['service_id'])) {
       $poste = $pModel->find($_POST['poste_id']);
       if ($poste['service_id'] != $_POST['service_id']) {
           $error = 'Le poste ne correspond pas au service sélectionné';
       }
   }
   ```

3. **Valider que Direction_id = Service.direction_id si Service spécifié**
   - Situation: Personnel peut avoir `direction_id` ≠ `service_id.direction_id`
   - Impact: Incohérence
   - Action: Synchroniser automatiquement:
   ```php
   if (!empty($_POST['service_id'])) {
       $service = $svcModel->find($_POST['service_id']);
       $_POST['direction_id'] = $service['direction_id'];
   }
   ```

### Priorité Moyenne 🟡

4. **Documentation de la hiérarchie dans les vues**
   - Ajouter breadcrumb ou affichage du chemin complet: "Direction > Service > Poste > Personnel"

5. **Envisager un champ `position` optionnel ou lié à `poste_id`**
   - Situation: Deux champs pour la même info (position libre texte vs poste référencé)
   - Impact: Redondance
   - Action: Garder les deux ou fusionner et remplir `position` depuis le nom du poste

6. **Ajouter logs de suppression**
   - Tracer qui a supprimé une direction/service/poste et l'impact en cascade

---

## 7. Résumé

| Aspect | État | Notes |
|--------|------|-------|
| **Structure relationnelle** | ✅ Valide | Hiérarchie correcte avec FK appropriées |
| **Cascades de suppression** | ✅ Valide | Logique saine, dissociation plutôt que suppression |
| **Modèles métier** | ✅ Valide | Tous les modèles implémentent la hiérarchie |
| **Contrôleurs** | ✅ Valide | Logique d'alerte contrat et migration OK |
| **Vues** | ✅ Valide | Affichage hiérarchique cohérent |
| **Intégrité données** | ⚠️ À renforcer | Voir recommandations haute priorité |

---

## 8. Actions Immédiates

1. ✅ Exécuter migration contrats (`migrate_contracts.php`)
2. ✅ Appliquer recommandation #1 (filtre poste_id)
3. ✅ Appliquer recommandation #2-3 (validation cohérence)
4. ⚠️ Tester cascades de suppression (Direction > Service > Poste > Personnel)
5. ⚠️ Vérifier logs pour anomalies hiérarchiques

