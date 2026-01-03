<?php require __DIR__ . '/../layout/header.php'; ?>

<div class="max-w-2xl mx-auto">
  <div class="bg-white dark:bg-slate-800 rounded-lg shadow-lg p-8">
    <div class="mb-8">
      <h1 class="text-3xl font-bold text-slate-900 dark:text-white">
        <?= isset($direction) ? '✏️ Modifier une direction' : '➕ Ajouter une direction' ?>
      </h1>
      <p class="text-slate-600 dark:text-slate-400 mt-2">Complétez le formulaire ci-dessous</p>
    </div>

    <form method="post" class="space-y-6">
      <div>
        <label class="block text-sm font-semibold text-slate-900 dark:text-white mb-2">Nom de la direction <span class="text-red-500">*</span></label>
        <input type="text" name="name" value="<?= isset($direction) ? h($direction['name']) : '' ?>" required class="w-full px-4 py-2 border border-slate-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-700 text-slate-900 dark:text-white placeholder-slate-400 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors" placeholder="ex: Direction Technique">
      </div>

      <div class="flex gap-4 pt-4">
        <button type="submit" class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors flex items-center gap-2">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
          </svg>
          <?= isset($direction) ? 'Mettre à jour' : 'Créer' ?>
        </button>
        <a href="index.php?page=directions" class="px-6 py-3 bg-slate-300 dark:bg-slate-700 hover:bg-slate-400 dark:hover:bg-slate-600 text-slate-900 dark:text-white font-medium rounded-lg transition-colors">
          Annuler
        </a>
      </div>
    </form>
  </div>
</div>

<?php require __DIR__ . '/../layout/footer.php'; ?>