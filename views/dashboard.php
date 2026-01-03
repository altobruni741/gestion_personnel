<?php require __DIR__ . '/layout/header.php'; ?>

<div class="space-y-8">
  <!-- Titre d'accueil -->
  <div class="bg-gradient-to-r from-blue-600 to-blue-700 dark:from-blue-900 dark:to-blue-800 text-white rounded-lg shadow-lg p-8">
    <h1 class="text-4xl font-bold mb-2">Bienvenue, <?=h($_SESSION['username'] ?? 'Utilisateur')?> 👋</h1>
    <p class="text-blue-100">Gérez efficacement votre personnel et vos ressources</p>
  </div>

  <!-- Statistiques -->
  <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
    <?php if (isset($stats)): ?>
      <!-- Directions -->
      <div class="bg-white dark:bg-slate-800 rounded-lg shadow p-6 border-l-4 border-purple-500">
        <div class="flex items-center justify-between">
          <div>
            <p class="text-slate-600 dark:text-slate-400 text-sm font-medium">Directions</p>
            <p class="text-3xl font-bold text-slate-900 dark:text-white mt-1"><?=$stats['directions'] ?? 0?></p>
          </div>
          <div class="w-12 h-12 rounded-full bg-purple-100 dark:bg-purple-900/30 flex items-center justify-center">
            <svg class="w-6 h-6 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5.581m0 0H9m0 0h-.581m0 0A2 2 0 105.9 6h.581m0 0a2 2 0 110 4.581m0-6.581a6 6 0 1 1-6 6"></path>
            </svg>
          </div>
        </div>
      </div>

      <!-- Services -->
      <div class="bg-white dark:bg-slate-800 rounded-lg shadow p-6 border-l-4 border-green-500">
        <div class="flex items-center justify-between">
          <div>
            <p class="text-slate-600 dark:text-slate-400 text-sm font-medium">Services</p>
            <p class="text-3xl font-bold text-slate-900 dark:text-white mt-1"><?=$stats['services'] ?? 0?></p>
          </div>
          <div class="w-12 h-12 rounded-full bg-green-100 dark:bg-green-900/30 flex items-center justify-center">
            <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
            </svg>
          </div>
        </div>
      </div>

      <!-- Personnel -->
      <div class="bg-white dark:bg-slate-800 rounded-lg shadow p-6 border-l-4 border-blue-500">
        <div class="flex items-center justify-between">
          <div>
            <p class="text-slate-600 dark:text-slate-400 text-sm font-medium">Personnel</p>
            <p class="text-3xl font-bold text-slate-900 dark:text-white mt-1"><?=$stats['personnel'] ?? 0?></p>
          </div>
          <div class="w-12 h-12 rounded-full bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center">
            <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-2a6 6 0 0112 0v2zm0 0h6v-2a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
            </svg>
          </div>
        </div>
      </div>

      <!-- Utilisateurs -->
      <div class="bg-white dark:bg-slate-800 rounded-lg shadow p-6 border-l-4 border-orange-500">
        <div class="flex items-center justify-between">
          <div>
            <p class="text-slate-600 dark:text-slate-400 text-sm font-medium">Utilisateurs</p>
            <p class="text-3xl font-bold text-slate-900 dark:text-white mt-1"><?=$stats['users'] ?? 0?></p>
          </div>
          <div class="w-12 h-12 rounded-full bg-orange-100 dark:bg-orange-900/30 flex items-center justify-center">
            <svg class="w-6 h-6 text-orange-600 dark:text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.856-1.487M15 10a3 3 0 11-6 0 3 3 0 016 0zM6 20a9 9 0 0118 0v2H6v-2z"></path>
            </svg>
          </div>
        </div>
      </div>
    <?php endif; ?>
  </div>

  <!-- Actions rapides -->
  <div class="bg-white dark:bg-slate-800 rounded-lg shadow p-6">
    <h2 class="text-xl font-bold text-slate-900 dark:text-white mb-6 flex items-center gap-2">
      <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
      </svg>
      Actions Rapides
    </h2>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
      <a href="index.php?page=personnel&action=create" class="p-4 rounded-lg border-2 border-blue-200 dark:border-blue-800 hover:bg-blue-50 dark:hover:bg-blue-900/20 transition-colors">
        <div class="flex items-center gap-3 text-blue-600 dark:text-blue-400 font-semibold">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
          </svg>
          Ajouter un employé
        </div>
      </a>
      <a href="index.php?page=services&action=create" class="p-4 rounded-lg border-2 border-green-200 dark:border-green-800 hover:bg-green-50 dark:hover:bg-green-900/20 transition-colors">
        <div class="flex items-center gap-3 text-green-600 dark:text-green-400 font-semibold">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
          </svg>
          Ajouter un service
        </div>
      </a>
      <a href="index.php?page=directions&action=create" class="p-4 rounded-lg border-2 border-purple-200 dark:border-purple-800 hover:bg-purple-50 dark:hover:bg-purple-900/20 transition-colors">
        <div class="flex items-center gap-3 text-purple-600 dark:text-purple-400 font-semibold">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
          </svg>
          Ajouter une direction
        </div>
      </a>
      <a href="index.php?page=personnel" class="p-4 rounded-lg border-2 border-slate-200 dark:border-slate-700 hover:bg-slate-50 dark:hover:bg-slate-700 transition-colors">
        <div class="flex items-center gap-3 text-slate-600 dark:text-slate-400 font-semibold">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
          </svg>
          Voir tout le personnel
        </div>
      </a>
    </div>
  </div>

  <!-- Informations d'aide -->
  <div class="bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-blue-900/20 dark:to-indigo-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-6">
    <h3 class="text-lg font-bold text-blue-900 dark:text-blue-100 mb-2 flex items-center gap-2">
      <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
      </svg>
      Conseils d'utilisation
    </h3>
    <ul class="text-blue-800 dark:text-blue-200 text-sm space-y-1">
      <li>✅ Commencez par créer des directions pour structurer votre organisation</li>
      <li>✅ Créez ensuite vos services et associez-les aux directions</li>
      <li>✅ Ajoutez le personnel en les associant à un service et une direction</li>
      <li>✅ Utilisez le mode sombre pour une meilleure expérience la nuit</li>
    </ul>
  </div>
</div>

<?php require __DIR__ . '/layout/footer.php'; ?>
