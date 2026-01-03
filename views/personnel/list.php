<?php require __DIR__ . '/../layout/header.php'; ?>

<div class="space-y-6">
  <!-- En-tête avec actions -->
  <div class="flex justify-between items-center">
    <div>
      <h1 class="text-3xl font-bold text-slate-900 dark:text-white">👥 Personnel</h1>
      <p class="text-slate-600 dark:text-slate-400 mt-1"><?=count($personnel)?> employés enregistrés</p>
    </div>
    <div class="flex gap-2">
      <a href="index.php?page=personnel&action=create" class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors flex items-center gap-2">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
        </svg>
        Ajouter un employé
      </a>
      <a href="index.php?page=personnel&action=list&export=csv" class="px-6 py-3 bg-green-600 hover:bg-green-700 text-white font-medium rounded-lg transition-colors flex items-center gap-2">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
        </svg>
        Exporter CSV
      </a>
    </div>
  </div>

  <!-- Filtres et recherche -->
  <div class="bg-white dark:bg-slate-800 rounded-lg shadow p-6">
    <?php if (!empty($needsContractMigration)): ?>
      <div class="mb-4 p-4 rounded-lg bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-800">
        <p class="text-sm text-yellow-800 dark:text-yellow-300 mb-3">Les colonnes de gestion des contrats sont manquantes. Pour activer la durée de contrat et les alertes, veuillez lancer la migration.</p>
        <form method="post" action="migrate_contracts.php" onsubmit="return confirm('Exécuter la migration des contrats maintenant ? Sauvegardez votre base avant.')">
          <button type="submit" class="px-4 py-2 bg-yellow-600 hover:bg-yellow-700 text-white rounded-md">Exécuter la migration des contrats</button>
          <a href="index.php?page=personnel&action=list" class="ml-3 text-sm text-slate-600 dark:text-slate-300">Ignorer</a>
        </form>
      </div>
    <?php endif; ?>
    <form method="get" class="space-y-4">
      <input type="hidden" name="page" value="personnel">
      <input type="hidden" name="action" value="list">
      
      <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <!-- Recherche -->
        <div>
          <label class="block text-sm font-semibold text-slate-900 dark:text-white mb-2">🔍 Recherche</label>
          <input type="text" name="search" value="<?=h($_GET['search'] ?? '')?>" placeholder="Nom, prénom, email..." class="w-full px-4 py-2 border border-slate-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-700 text-slate-900 dark:text-white placeholder-slate-400 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors">
        </div>

        <!-- Filtre par statut -->
        <div>
          <label class="block text-sm font-semibold text-slate-900 dark:text-white mb-2">Statut</label>
          <select name="status" class="w-full px-4 py-2 border border-slate-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-700 text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors">
            <option value="">-- Tous les statuts --</option>
            <option value="Actif" <?=(($_GET['status'] ?? '') === 'Actif') ? 'selected' : ''?>>Actif</option>
            <option value="Inactif" <?=(($_GET['status'] ?? '') === 'Inactif') ? 'selected' : ''?>>Inactif</option>
            <option value="En Congé" <?=(($_GET['status'] ?? '') === 'En Congé') ? 'selected' : ''?>>En Congé</option>
            <option value="Retraité" <?=(($_GET['status'] ?? '') === 'Retraité') ? 'selected' : ''?>>Retraité</option>
          </select>
        </div>

        <!-- Filtre par direction -->
        <div>
          <label class="block text-sm font-semibold text-slate-900 dark:text-white mb-2">Direction</label>
          <select name="direction_id" class="w-full px-4 py-2 border border-slate-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-700 text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors">
            <option value="">-- Toutes les directions --</option>
            <?php foreach($directions as $d): ?>
              <option value="<?=h($d['id'])?>" <?=!empty($_GET['direction_id']) && $_GET['direction_id'] == $d['id'] ? 'selected' : ''?>><?=h($d['name'])?></option>
            <?php endforeach; ?>
          </select>
        </div>

        <!-- Filtre par service -->
        <div>
          <label class="block text-sm font-semibold text-slate-900 dark:text-white mb-2">Service</label>
          <select name="service_id" class="w-full px-4 py-2 border border-slate-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-700 text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors">
            <option value="">-- Tous les services --</option>
            <?php foreach($services as $s): ?>
              <option value="<?=h($s['id'])?>" <?=!empty($_GET['service_id']) && $_GET['service_id'] == $s['id'] ? 'selected' : ''?>><?=h($s['name'])?></option>
            <?php endforeach; ?>
          </select>
        </div>
      </div>

      <div class="flex gap-2 pt-2">
        <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors">
          🔎 Filtrer
        </button>
        <a href="index.php?page=personnel&action=list" class="px-4 py-2 bg-slate-300 dark:bg-slate-700 hover:bg-slate-400 dark:hover:bg-slate-600 text-slate-900 dark:text-white font-medium rounded-lg transition-colors">
          Réinitialiser
        </a>
      </div>
    </form>
  </div>

  <!-- Statistiques -->
  <?php if (!empty($stats)): ?>
    <?php if (!empty($expiring)): ?>
      <div class="bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-800 rounded-lg p-4 mb-4">
        <p class="text-sm text-yellow-800 dark:text-yellow-300">⚠ <?=count($expiring)?> contrat(s) arrivent à expiration dans les 10 prochains jours. <a href="#expiring" class="underline font-semibold">Voir</a></p>
      </div>
    <?php endif; ?>
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
      <div class="bg-white dark:bg-slate-800 rounded-lg shadow p-4 border-l-4 border-green-500">
        <p class="text-sm text-slate-600 dark:text-slate-400">Actifs</p>
        <p class="text-2xl font-bold text-slate-900 dark:text-white"><?=$stats['active'] ?? 0?></p>
      </div>
      <div class="bg-white dark:bg-slate-800 rounded-lg shadow p-4 border-l-4 border-blue-500">
        <p class="text-sm text-slate-600 dark:text-slate-400">Total</p>
        <p class="text-2xl font-bold text-slate-900 dark:text-white"><?=$stats['total'] ?? 0?></p>
      </div>
      <div class="bg-white dark:bg-slate-800 rounded-lg shadow p-4 border-l-4 border-purple-500">
        <p class="text-sm text-slate-600 dark:text-slate-400">Directions</p>
        <p class="text-2xl font-bold text-slate-900 dark:text-white"><?=count($stats['by_direction'] ?? [])?></p>
      </div>
      <div class="bg-white dark:bg-slate-800 rounded-lg shadow p-4 border-l-4 border-orange-500">
        <p class="text-sm text-slate-600 dark:text-slate-400">Services</p>
        <p class="text-2xl font-bold text-slate-900 dark:text-white"><?=count($stats['by_service'] ?? [])?></p>
      </div>
    </div>
  <?php endif; ?>

  <!-- Liste du personnel -->
  <?php if (empty($personnel)): ?>
    <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-6 text-center">
      <svg class="w-12 h-12 mx-auto text-blue-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-2a6 6 0 0112 0v2zm0 0h6v-2a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
      </svg>
      <p class="text-slate-600 dark:text-slate-400">Aucun employé trouvé. <a href="index.php?page=personnel&action=create" class="text-blue-600 dark:text-blue-400 hover:underline font-semibold">Ajouter un employé</a></p>
    </div>
  <?php else: ?>
    <div class="overflow-x-auto bg-white dark:bg-slate-800 rounded-lg shadow">
      <table class="w-full">
        <thead class="bg-slate-50 dark:bg-slate-700 border-b border-slate-200 dark:border-slate-600">
          <tr>
            <th class="px-6 py-3 text-left text-sm font-semibold text-slate-900 dark:text-white">Nom</th>
            <th class="px-6 py-3 text-left text-sm font-semibold text-slate-900 dark:text-white">Contact</th>
            <th class="px-6 py-3 text-left text-sm font-semibold text-slate-900 dark:text-white">Poste</th>
            <th class="px-6 py-3 text-left text-sm font-semibold text-slate-900 dark:text-white">Service</th>
            <th class="px-6 py-3 text-left text-sm font-semibold text-slate-900 dark:text-white">Direction</th>
            <th class="px-6 py-3 text-left text-sm font-semibold text-slate-900 dark:text-white">Statut</th>
            <th class="px-6 py-3 text-right text-sm font-semibold text-slate-900 dark:text-white">Actions</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-slate-200 dark:divide-slate-700">
          <?php 
          $foundFirstExpiring = false;
          foreach($personnel as $p): 
            $isExpiring = false;
            if (!empty($p['contract_end'])) {
                $days = (int) ceil((strtotime($p['contract_end']) - time()) / 86400);
                if ($days >= 0 && $days <= 10) $isExpiring = true;
            }
            $rowId = "";
            if ($isExpiring && !$foundFirstExpiring) {
                $rowId = 'id="expiring"';
                $foundFirstExpiring = true;
            }
            $rowClass = $isExpiring ? 'bg-yellow-50/30 dark:bg-yellow-900/10' : '';
          ?>
            <tr <?= $rowId ?> class="hover:bg-slate-50 dark:hover:bg-slate-700/50 transition-colors <?= $rowClass ?> scroll-mt-24">
              <td class="px-6 py-4">
                <div>
                  <p class="text-sm font-bold text-slate-900 dark:text-white"><?=h($p['firstname'])?> <?=h($p['lastname'])?>
                    <?php if (!empty($p['contract_end'])):
                      $days = (int) ceil((strtotime($p['contract_end']) - time()) / 86400);
                      if ($days >= 0 && $days <= 10): ?>
                        <span title="Contrat se termine dans <?=$days?> jours" class="ml-2 inline-flex items-center px-2 py-0.5 rounded-md text-xs font-medium bg-yellow-100 dark:bg-yellow-900/30 text-yellow-800 dark:text-yellow-300">⚠ <?=$days?>j</span>
                      <?php endif; endif; ?>
                  </p>
                  <p class="text-xs text-slate-500 dark:text-slate-400">ID: <?=h($p['id'])?></p>
                </div>
              </td>
              <td class="px-6 py-4 text-sm">
                <div class="space-y-1">
                  <?php if ($p['email']): ?>
                    <p><a href="mailto:<?=h($p['email'])?>" class="text-blue-600 dark:text-blue-400 hover:underline"><?=h($p['email'])?></a></p>
                  <?php endif; ?>
                  <?php if ($p['phone']): ?>
                    <p class="text-slate-600 dark:text-slate-400"><?=h($p['phone'])?></p>
                  <?php endif; ?>
                </div>
              </td>
              <td class="px-6 py-4 text-sm text-slate-600 dark:text-slate-400"><?=h($p['poste_name'] ?? ($p['position'] ?: '-'))?></td>
              <td class="px-6 py-4 text-sm">
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-300">
                  <?=h($p['service_name'] ?? '-')?>
                </span>
              </td>
              <td class="px-6 py-4 text-sm">
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 dark:bg-purple-900/30 text-purple-800 dark:text-purple-300">
                  <?=h(substr($p['direction_name'] ?? '-', 0, 30))?>
                </span>
              </td>
              <td class="px-6 py-4 text-sm">
                <?php
                  $statusClass = $p['status'] === 'Actif' ? 'bg-blue-100 dark:bg-blue-900/30 text-blue-800 dark:text-blue-300' : 
                                ($p['status'] === 'En Congé' ? 'bg-yellow-100 dark:bg-yellow-900/30 text-yellow-800 dark:text-yellow-300' : 
                                'bg-red-100 dark:bg-red-900/30 text-red-800 dark:text-red-300');
                ?>
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium <?=$statusClass?>">
                  <?=h($p['status'] ?? '-')?>
                </span>
              </td>
              <td class="px-6 py-4 text-sm text-right">
                <div class="flex items-center justify-end gap-2">
                  <a href="index.php?page=personnel&action=view&id=<?=h($p['id'])?>" title="Voir les détails" class="inline-flex items-center px-2 py-2 rounded-lg bg-slate-200 dark:bg-slate-700 hover:bg-slate-300 dark:hover:bg-slate-600 text-slate-900 dark:text-white transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                    </svg>
                  </a>
                  <a href="index.php?page=personnel&action=edit&id=<?=h($p['id'])?>" class="inline-flex items-center px-3 py-2 rounded-lg bg-blue-500 hover:bg-blue-600 text-white text-xs font-medium transition-colors">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                    Éditer
                  </a>
                  <a href="index.php?page=personnel&action=delete&id=<?=h($p['id'])?>" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet employé ?')" class="inline-flex items-center px-3 py-2 rounded-lg bg-red-500 hover:bg-red-600 text-white text-xs font-medium transition-colors">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                    </svg>
                    Supprimer
                  </a>
                </div>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  <?php endif; ?>
</div>

<?php require __DIR__ . '/../layout/footer.php'; ?>