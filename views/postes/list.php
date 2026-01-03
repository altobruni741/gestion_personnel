<div class="max-w-7xl mx-auto px-4 py-8">
  <!-- Header -->
  <div class="flex items-center justify-between mb-8">
    <div>
      <h1 class="text-3xl font-bold text-slate-900 dark:text-white">Gestion des Postes</h1>
      <p class="text-slate-600 dark:text-slate-400 mt-2">Organisez vos postes par Direction → Service → Poste</p>
    </div>
    <a href="index.php?page=poste&action=create" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium transition">
      + Ajouter un poste
    </a>
  </div>

  <!-- Filtres -->
  <div class="bg-white dark:bg-slate-800 rounded-lg shadow p-6 mb-6">
    <form method="GET" class="grid grid-cols-1 md:grid-cols-3 gap-4">
      <input type="hidden" name="page" value="poste">
      <input type="hidden" name="action" value="list">
      
      <div>
        <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Direction</label>
        <select name="direction_id" class="w-full px-3 py-2 border border-slate-300 dark:border-slate-600 rounded-lg dark:bg-slate-700 dark:text-white">
          <option value="">-- Toutes les directions --</option>
          <?php foreach ($directions as $d): ?>
            <option value="<?=$d['id']?>" <?=($_GET['direction_id'] ?? '') == $d['id'] ? 'selected' : ''?>>
              <?=h($d['name'])?>
            </option>
          <?php endforeach; ?>
        </select>
      </div>
      
      <div>
        <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Service</label>
        <select name="service_id" class="w-full px-3 py-2 border border-slate-300 dark:border-slate-600 rounded-lg dark:bg-slate-700 dark:text-white">
          <option value="">-- Tous les services --</option>
          <?php foreach ($services as $s): ?>
            <option value="<?=$s['id']?>" <?=($_GET['service_id'] ?? '') == $s['id'] ? 'selected' : ''?>>
              <?=h($s['name'])?> (<?=h($s['direction_name'])?>)
            </option>
          <?php endforeach; ?>
        </select>
      </div>
      
      <div class="flex items-end">
        <button type="submit" class="w-full px-4 py-2 bg-slate-600 hover:bg-slate-700 text-white rounded-lg font-medium transition">
          Filtrer
        </button>
        <a href="index.php?page=poste&action=list" class="ml-2 px-4 py-2 bg-slate-200 hover:bg-slate-300 dark:bg-slate-700 dark:hover:bg-slate-600 text-slate-900 dark:text-white rounded-lg font-medium transition">
          Réinitialiser
        </a>
      </div>
    </form>
  </div>

  <!-- Statistiques -->
  <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
    <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-4">
      <p class="text-blue-600 dark:text-blue-400 text-sm font-medium">Total postes</p>
      <p class="text-3xl font-bold text-blue-900 dark:text-blue-100"><?=count($postes)?></p>
    </div>
    
    <?php 
      $directions_count = count(array_unique(array_column($postes, 'direction_id')));
      $services_count = count(array_unique(array_column($postes, 'service_id')));
    ?>
    
    <div class="bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-lg p-4">
      <p class="text-green-600 dark:text-green-400 text-sm font-medium">Directions</p>
      <p class="text-3xl font-bold text-green-900 dark:text-green-100"><?=$directions_count?></p>
    </div>
    
    <div class="bg-purple-50 dark:bg-purple-900/20 border border-purple-200 dark:border-purple-800 rounded-lg p-4">
      <p class="text-purple-600 dark:text-purple-400 text-sm font-medium">Services</p>
      <p class="text-3xl font-bold text-purple-900 dark:text-purple-100"><?=$services_count?></p>
    </div>
    
    <div class="bg-amber-50 dark:bg-amber-900/20 border border-amber-200 dark:border-amber-800 rounded-lg p-4">
      <p class="text-amber-600 dark:text-amber-400 text-sm font-medium">Postes vides</p>
      <p class="text-3xl font-bold text-amber-900 dark:text-amber-100">
        <?php
          $empty_count = 0;
          foreach ($postes as $p) {
            $stats = $posteModel->getStats($p['id']);
            if ($stats['total'] == 0) $empty_count++;
          }
          echo $empty_count;
        ?>
      </p>
    </div>
  </div>

  <!-- Liste des postes -->
  <?php if (empty($postes)): ?>
    <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-8 text-center">
      <p class="text-blue-900 dark:text-blue-100 mb-4">Aucun poste trouvé</p>
      <a href="index.php?page=poste&action=create" class="inline-block px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg">
        Créer le premier poste
      </a>
    </div>
  <?php else: ?>
    <div class="bg-white dark:bg-slate-800 rounded-lg shadow overflow-hidden">
      <table class="w-full">
        <thead class="bg-slate-100 dark:bg-slate-700 border-b border-slate-200 dark:border-slate-600">
          <tr>
            <th class="px-6 py-3 text-left text-xs font-semibold text-slate-900 dark:text-white uppercase">Poste</th>
            <th class="px-6 py-3 text-left text-xs font-semibold text-slate-900 dark:text-white uppercase">Service</th>
            <th class="px-6 py-3 text-left text-xs font-semibold text-slate-900 dark:text-white uppercase">Direction</th>
            <th class="px-6 py-3 text-center text-xs font-semibold text-slate-900 dark:text-white uppercase">Personnel</th>
            <th class="px-6 py-3 text-right text-xs font-semibold text-slate-900 dark:text-white uppercase">Actions</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-slate-200 dark:divide-slate-700">
          <?php foreach ($postes as $p): 
            $stats = $posteModel->getStats($p['id']);
          ?>
            <tr class="hover:bg-slate-50 dark:hover:bg-slate-700/50 transition">
              <td class="px-6 py-4">
                <a href="index.php?page=poste&action=view&id=<?=$p['id']?>" class="font-medium text-blue-600 dark:text-blue-400 hover:underline">
                  <?=h($p['name'])?>
                </a>
                <?php if ($p['description']): ?>
                  <p class="text-sm text-slate-500 dark:text-slate-400"><?=h(substr($p['description'], 0, 50))?>...</p>
                <?php endif; ?>
              </td>
              <td class="px-6 py-4">
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 dark:bg-purple-900/30 text-purple-800 dark:text-purple-300">
                  <?=h($p['service_name'])?>
                </span>
              </td>
              <td class="px-6 py-4">
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 dark:bg-blue-900/30 text-blue-800 dark:text-blue-300">
                  <?=h($p['direction_name'])?>
                </span>
              </td>
              <td class="px-6 py-4 text-center">
                <span class="px-3 py-1 bg-slate-100 dark:bg-slate-700 rounded-full text-sm font-medium text-slate-900 dark:text-white">
                  <?=$stats['total']?> employé<?=$stats['total'] != 1 ? 's' : ''?>
                </span>
              </td>
              <td class="px-6 py-4 text-right">
                <div class="flex items-center justify-end gap-2">
                  <a href="index.php?page=poste&action=view&id=<?=$p['id']?>" class="text-blue-600 dark:text-blue-400 hover:text-blue-900 dark:hover:text-blue-300">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                    </svg>
                  </a>
                  <a href="index.php?page=poste&action=edit&id=<?=$p['id']?>" class="text-amber-600 dark:text-amber-400 hover:text-amber-900 dark:hover:text-amber-300">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                  </a>
                  <form method="POST" action="index.php?page=poste&action=delete&id=<?=$p['id']?>" style="display:inline;" onsubmit="return confirm('Êtes-vous sûr ?')">
                    <button type="submit" class="text-red-600 dark:text-red-400 hover:text-red-900 dark:hover:text-red-300">
                      <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                      </svg>
                    </button>
                  </form>
                </div>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  <?php endif; ?>
</div>
