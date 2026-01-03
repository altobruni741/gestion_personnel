<?php require __DIR__ . '/../layout/header.php'; ?>

<div class="space-y-6">
  <div class="flex justify-between items-center">
    <div>
      <h1 class="text-3xl font-bold text-slate-900 dark:text-white">Services</h1>
      <p class="text-slate-600 dark:text-slate-400 mt-1"><?=count($services)?> services</p>
    </div>
    <a href="index.php?page=services&action=create" class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors flex items-center gap-2">
      <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
      </svg>
      Ajouter un service
    </a>
  </div>

  <?php if (empty($services)): ?>
    <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-6 text-center">
      <svg class="w-12 h-12 mx-auto text-blue-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
      </svg>
      <p class="text-slate-600 dark:text-slate-400">Aucun service enregistré. Commencez par <a href="index.php?page=services&action=create" class="text-blue-600 dark:text-blue-400 hover:underline font-semibold">ajouter un service</a>.</p>
    </div>
  <?php else: ?>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
      <?php foreach($services as $s): ?>
        <div class="bg-white dark:bg-slate-800 rounded-lg shadow hover:shadow-lg transition-shadow p-6">
          <div class="flex items-start justify-between mb-4">
            <div>
              <h3 class="text-lg font-bold text-slate-900 dark:text-white"><?=h($s['name'])?></h3>
              <p class="text-sm text-slate-600 dark:text-slate-400 mt-1">
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 dark:bg-purple-900/30 text-purple-800 dark:text-purple-300">
                  <?=h($s['direction_name'])?>
                </span>
              </p>
            </div>
          </div>
          <div class="flex gap-2 pt-4">
            <a href="index.php?page=services&action=edit&id=<?=h($s['id'])?>" class="flex-1 text-center px-3 py-2 rounded-lg bg-blue-500 hover:bg-blue-600 text-white text-sm font-medium transition-colors">
              Éditer
            </a>
            <a href="index.php?page=services&action=delete&id=<?=h($s['id'])?>" onclick="return confirm('Êtes-vous sûr ?')" class="flex-1 text-center px-3 py-2 rounded-lg bg-red-500 hover:bg-red-600 text-white text-sm font-medium transition-colors">
              Supprimer
            </a>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  <?php endif; ?>
</div>

<?php require __DIR__ . '/../layout/footer.php'; ?>