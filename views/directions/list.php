<?php require __DIR__ . '/../layout/header.php'; ?>

<div class="space-y-6">
  <div class="flex justify-between items-center">
    <div>
      <h1 class="text-3xl font-bold text-slate-900 dark:text-white">Directions</h1>
      <p class="text-slate-600 dark:text-slate-400 mt-1"><?=count($directions)?> directions</p>
    </div>
    <a href="index.php?page=directions&action=create" class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors flex items-center gap-2">
      <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
      </svg>
      Ajouter une direction
    </a>
  </div>

  <?php if (empty($directions)): ?>
    <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-6 text-center">
      <svg class="w-12 h-12 mx-auto text-blue-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5.581m0 0H9m0 0h-.581m0 0A2 2 0 105.9 6h.581m0 0a2 2 0 110 4.581m0-6.581a6 6 0 1 1-6 6"></path>
      </svg>
      <p class="text-slate-600 dark:text-slate-400">Aucune direction enregistrée. Commencez par <a href="index.php?page=directions&action=create" class="text-blue-600 dark:text-blue-400 hover:underline font-semibold">ajouter une direction</a>.</p>
    </div>
  <?php else: ?>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
      <?php foreach($directions as $d): ?>
        <div class="bg-white dark:bg-slate-800 rounded-lg shadow hover:shadow-lg transition-shadow p-6">
          <div class="flex items-start justify-between mb-4">
            <h3 class="text-lg font-bold text-slate-900 dark:text-white"><?=h($d['name'])?></h3>
            <div class="w-8 h-8 rounded-full bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center">
              <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5.581m0 0H9m0 0h-.581m0 0A2 2 0 105.9 6h.581m0 0a2 2 0 110 4.581m0-6.581a6 6 0 1 1-6 6"></path>
              </svg>
            </div>
          </div>
          <p class="text-sm text-slate-600 dark:text-slate-400 mb-4">Direction ID: <span class="font-mono text-xs bg-slate-100 dark:bg-slate-700 px-2 py-1 rounded"><?=h($d['id'])?></span></p>
          <div class="flex gap-2 pt-4">
            <a href="index.php?page=directions&action=edit&id=<?=h($d['id'])?>" class="flex-1 text-center px-3 py-2 rounded-lg bg-blue-500 hover:bg-blue-600 text-white text-sm font-medium transition-colors">
              Éditer
            </a>
            <a href="index.php?page=directions&action=delete&id=<?=h($d['id'])?>" onclick="return confirm('Êtes-vous sûr ?')" class="flex-1 text-center px-3 py-2 rounded-lg bg-red-500 hover:bg-red-600 text-white text-sm font-medium transition-colors">
              Supprimer
            </a>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  <?php endif; ?>
</div>

<?php require __DIR__ . '/../layout/footer.php'; ?>