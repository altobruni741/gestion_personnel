<div class="max-w-4xl mx-auto px-4 py-8">
  <!-- Header -->
  <div class="bg-white dark:bg-slate-800 rounded-lg shadow p-6 mb-6">
    <div class="flex items-start justify-between">
      <div>
        <h1 class="text-3xl font-bold text-slate-900 dark:text-white"><?=h($poste['name'])?></h1>
        <div class="flex flex-wrap gap-2 mt-3">
          <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-purple-100 dark:bg-purple-900/30 text-purple-800 dark:text-purple-300">
            <?=h($service['name'] ?? '')?>
          </span>
          <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 dark:bg-blue-900/30 text-blue-800 dark:text-blue-300">
            <?=h($poste['direction_name'] ?? '')?>
          </span>
        </div>
      </div>
      <div class="flex gap-2">
        <a href="index.php?page=poste&action=edit&id=<?=$poste['id']?>" class="px-4 py-2 bg-amber-600 hover:bg-amber-700 text-white rounded-lg font-medium transition">
          Modifier
        </a>
        <form method="POST" action="index.php?page=poste&action=delete&id=<?=$poste['id']?>" style="display:inline;" onsubmit="return confirm('Êtes-vous sûr ? Cette action ne peut pas être annulée.')">
          <button type="submit" class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg font-medium transition">
            Supprimer
          </button>
        </form>
      </div>
    </div>
    
    <?php if ($poste['description']): ?>
      <p class="text-slate-600 dark:text-slate-400 mt-4"><?=h($poste['description'])?></p>
    <?php endif; ?>
  </div>

  <!-- Statistiques -->
  <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
    <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-4">
      <p class="text-blue-600 dark:text-blue-400 text-sm font-medium">Total personnel</p>
      <p class="text-3xl font-bold text-blue-900 dark:text-blue-100"><?=$stats['total'] ?? 0?></p>
    </div>
    
    <div class="bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-lg p-4">
      <p class="text-green-600 dark:text-green-400 text-sm font-medium">Actif</p>
      <p class="text-3xl font-bold text-green-900 dark:text-green-100"><?=$stats['actifs'] ?? 0?></p>
    </div>
    
    <div class="bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-800 rounded-lg p-4">
      <p class="text-yellow-600 dark:text-yellow-400 text-sm font-medium">En congé</p>
      <p class="text-3xl font-bold text-yellow-900 dark:text-yellow-100"><?=$stats['en_conge'] ?? 0?></p>
    </div>
    
    <div class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg p-4">
      <p class="text-red-600 dark:text-red-400 text-sm font-medium">Inactif</p>
      <p class="text-3xl font-bold text-red-900 dark:text-red-100"><?=($stats['inactifs'] ?? 0) + ($stats['retraites'] ?? 0)?></p>
    </div>
  </div>

  <!-- Personnel du poste -->
  <div class="bg-white dark:bg-slate-800 rounded-lg shadow p-6">
    <h2 class="text-2xl font-bold text-slate-900 dark:text-white mb-4">Personnel assigné</h2>
    
    <?php if (empty($personnel)): ?>
      <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-6 text-center">
        <p class="text-blue-900 dark:text-blue-100 mb-4">Aucun employé assigné à ce poste</p>
        <a href="index.php?page=personnel&action=create&poste_id=<?=$poste['id']?>" class="inline-block px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg">
          Ajouter un employé
        </a>
      </div>
    <?php else: ?>
      <div class="overflow-x-auto">
        <table class="w-full text-sm">
          <thead class="bg-slate-100 dark:bg-slate-700 border-b border-slate-200 dark:border-slate-600">
            <tr>
              <th class="px-4 py-2 text-left font-semibold text-slate-900 dark:text-white">Nom</th>
              <th class="px-4 py-2 text-left font-semibold text-slate-900 dark:text-white">Email</th>
              <th class="px-4 py-2 text-left font-semibold text-slate-900 dark:text-white">Statut</th>
              <th class="px-4 py-2 text-left font-semibold text-slate-900 dark:text-white">Actions</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-slate-200 dark:divide-slate-700">
            <?php foreach ($personnel as $p): ?>
              <tr class="hover:bg-slate-50 dark:hover:bg-slate-700/50">
                <td class="px-4 py-3">
                  <a href="index.php?page=personnel&action=view&id=<?=$p['id']?>" class="text-blue-600 dark:text-blue-400 hover:underline font-medium">
                    <?=h($p['firstname'] . ' ' . $p['lastname'])?>
                  </a>
                </td>
                <td class="px-4 py-3">
                  <?php if ($p['email']): ?>
                    <a href="mailto:<?=h($p['email'])?>" class="text-blue-600 dark:text-blue-400 hover:underline">
                      <?=h($p['email'])?>
                    </a>
                  <?php else: ?>
                    <span class="text-slate-500 dark:text-slate-400">-</span>
                  <?php endif; ?>
                </td>
                <td class="px-4 py-3">
                  <?php
                    $statusClass = $p['status'] === 'Actif' ? 'bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-300' : 
                                  ($p['status'] === 'En Congé' ? 'bg-yellow-100 dark:bg-yellow-900/30 text-yellow-800 dark:text-yellow-300' : 
                                  'bg-red-100 dark:bg-red-900/30 text-red-800 dark:text-red-300');
                  ?>
                  <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium <?=$statusClass?>">
                    <?=h($p['status'])?>
                  </span>
                </td>
                <td class="px-4 py-3">
                  <a href="index.php?page=personnel&action=view&id=<?=$p['id']?>" class="text-blue-600 dark:text-blue-400 hover:text-blue-900 dark:hover:text-blue-300">
                    Voir →
                  </a>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    <?php endif; ?>
  </div>

  <!-- Navigation -->
  <div class="mt-6">
    <a href="index.php?page=poste&action=list" class="text-blue-600 dark:text-blue-400 hover:underline">
      ← Retour à la liste des postes
    </a>
  </div>
</div>
