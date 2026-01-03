<?php require __DIR__ . '/../layout/header.php'; ?>

<div class="min-h-screen flex items-center justify-center -mx-4 -my-8">
  <div class="w-full max-w-md">
    <div class="bg-white dark:bg-slate-800 rounded-lg shadow-lg p-8">
      <div class="text-center mb-8">
        <div class="w-20 h-20 rounded-full bg-white dark:bg-slate-700 flex items-center justify-center mx-auto mb-4 shadow-sm border border-slate-200 dark:border-slate-600 overflow-hidden">
          <img src="assets/images/logo_faritany.jpg" alt="Logo" class="w-full h-full object-cover">
        </div>
        <h1 class="text-2xl font-bold text-slate-900 dark:text-white">Créer un compte</h1>
        <p class="text-slate-600 dark:text-slate-400 mt-2">Rejoignez-nous dès maintenant</p>
      </div>

      <?php if (!empty($error)): ?>
        <div class="mb-6 p-4 rounded-lg bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800">
          <div class="flex gap-3">
            <svg class="w-5 h-5 text-red-600 dark:text-red-400 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
              <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
            </svg>
            <p class="text-red-700 dark:text-red-300 text-sm"><?=h($error)?></p>
          </div>
        </div>
      <?php endif; ?>

      <form method="post" class="space-y-4">
        <div>
          <label class="block text-sm font-semibold text-slate-900 dark:text-white mb-2">Nom d'utilisateur</label>
          <input type="text" name="username" value="<?=h($_POST['username'] ?? '')?>" required class="w-full px-4 py-2 border border-slate-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-700 text-slate-900 dark:text-white placeholder-slate-400 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors" placeholder="Choisissez un nom d'utilisateur">
        </div>

        <div>
          <label class="block text-sm font-semibold text-slate-900 dark:text-white mb-2">Mot de passe</label>
          <input type="password" name="password" required class="w-full px-4 py-2 border border-slate-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-700 text-slate-900 dark:text-white placeholder-slate-400 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors" placeholder="••••••••">
          <p class="text-xs text-slate-600 dark:text-slate-400 mt-1">Au moins 8 caractères</p>
        </div>

        <div>
          <label class="block text-sm font-semibold text-slate-900 dark:text-white mb-2">Confirmer le mot de passe</label>
          <input type="password" name="password2" required class="w-full px-4 py-2 border border-slate-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-700 text-slate-900 dark:text-white placeholder-slate-400 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors" placeholder="••••••••">
        </div>

        <button type="submit" class="w-full py-3 bg-green-600 hover:bg-green-700 text-white font-medium rounded-lg transition-colors mt-6">
          Créer mon compte
        </button>
      </form>

      <div class="mt-6 pt-6 border-t border-slate-200 dark:border-slate-700">
        <p class="text-sm text-slate-600 dark:text-slate-400 text-center">
          Vous avez déjà un compte ?
          <a href="index.php?page=auth&action=login" class="text-blue-600 dark:text-blue-400 hover:underline font-semibold">Se connecter</a>
        </p>
      </div>
    </div>
  </div>
</div>

<?php require __DIR__ . '/../layout/footer.php'; ?>