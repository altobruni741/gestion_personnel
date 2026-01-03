<!doctype html>
<html lang="fr"><head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Gestion du Personnel</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="assets/style.css">
  <script>
    if (localStorage.getItem('dark') === 'true') {
      document.documentElement.classList.add('dark');
    }
  </script>
  <style>
    .dark-toggle { cursor: pointer; }
  </style>
</head>
<body class="bg-white dark:bg-slate-900 text-slate-900 dark:text-slate-100 transition-colors duration-200">

<header class="sticky top-0 z-50 bg-white dark:bg-slate-800 border-b border-slate-200 dark:border-slate-700 shadow-sm">
  <nav class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
    <div class="flex justify-between items-center">
      <a href="index.php" class="text-2xl font-bold text-blue-600 dark:text-blue-400 flex items-center gap-2">
        <img src="assets/images/logo_faritany.jpg" alt="Logo" class="w-10 h-10 object-contain rounded-md">
        Gestion Personnel
      </a>
      
      <div class="hidden md:flex items-center gap-6">
        <?php if (!empty($_SESSION['user_id'])): ?>
          <a href="index.php?page=directions" class="px-3 py-2 rounded-lg hover:bg-slate-100 dark:hover:bg-slate-700 transition-colors font-medium">Directions</a>
          <a href="index.php?page=services" class="px-3 py-2 rounded-lg hover:bg-slate-100 dark:hover:bg-slate-700 transition-colors font-medium">Services</a>
          <a href="index.php?page=poste" class="px-3 py-2 rounded-lg hover:bg-slate-100 dark:hover:bg-slate-700 transition-colors font-medium">Postes</a>
          <a href="index.php?page=personnel" class="px-3 py-2 rounded-lg hover:bg-slate-100 dark:hover:bg-slate-700 transition-colors font-medium">Personnel</a>
        <?php endif; ?>
      </div>

      <div class="flex items-center gap-4">
        <button class="dark-toggle p-2 rounded-lg hover:bg-slate-100 dark:hover:bg-slate-700" title="Basculer le mode sombre">
          <svg class="w-5 h-5 dark:hidden" fill="currentColor" viewBox="0 0 20 20"><path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"></path></svg>
          <svg class="w-5 h-5 hidden dark:block" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.707.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.464 5.05l-.707-.707a1 1 0 00-1.414 1.414l.707.707zm5.657-9.193a1 1 0 00-1.414 0l-.707.707A1 1 0 005.05 6.464l.707-.707a1 1 0 001.414-1.414zM5 8a1 1 0 100-2H4a1 1 0 100 2h1z" clip-rule="evenodd"></path></svg>
        </button>

        <?php if (!empty($_SESSION['user_id'])): ?>
          <div class="hidden sm:flex items-center gap-3 border-l border-slate-200 dark:border-slate-700 pl-4">
            <span class="text-sm font-medium">Bonjour, <?=h($_SESSION['username'] ?? '')?></span>
            <a href="index.php?page=auth&action=logout" class="px-3 py-2 rounded-lg bg-red-500 hover:bg-red-600 text-white transition-colors font-medium text-sm">Déconnexion</a>
          </div>
        <?php else: ?>
          <a href="index.php?page=auth&action=login" class="hidden sm:inline-block px-3 py-2 rounded-lg hover:bg-slate-100 dark:hover:bg-slate-700 transition-colors font-medium">Connexion</a>
        <?php endif; ?>

        <button id="mobile-menu-btn" class="md:hidden p-2 rounded-lg hover:bg-slate-100 dark:hover:bg-slate-700">
          <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
          </svg>
        </button>
      </div>
    </div>

    <!-- Mobile menu -->
    <div id="mobile-menu" class="hidden md:hidden pt-4 border-t border-slate-200 dark:border-slate-700 mt-4">
      <?php if (!empty($_SESSION['user_id'])): ?>
        <a href="index.php?page=directions" class="block px-3 py-2 rounded-lg hover:bg-slate-100 dark:hover:bg-slate-700">Directions</a>
        <a href="index.php?page=services" class="block px-3 py-2 rounded-lg hover:bg-slate-100 dark:hover:bg-slate-700">Services</a>
        <a href="index.php?page=personnel" class="block px-3 py-2 rounded-lg hover:bg-slate-100 dark:hover:bg-slate-700">Personnel</a>
        <a href="index.php?page=auth&action=logout" class="block px-3 py-2 rounded-lg text-red-600 dark:text-red-400 mt-2">Déconnexion</a>
      <?php else: ?>
        <a href="index.php?page=auth&action=login" class="block px-3 py-2 rounded-lg hover:bg-slate-100 dark:hover:bg-slate-700">Connexion</a>
        <a href="index.php?page=auth&action=register" class="block px-3 py-2 rounded-lg hover:bg-slate-100 dark:hover:bg-slate-700">Créer un compte</a>
      <?php endif; ?>
    </div>
  </nav>
</header>

<script>
  // Dark mode toggle
  document.querySelector('.dark-toggle').addEventListener('click', function() {
    document.documentElement.classList.toggle('dark');
    localStorage.setItem('dark', document.documentElement.classList.contains('dark'));
  });
  
  // Mobile menu toggle
  document.getElementById('mobile-menu-btn')?.addEventListener('click', function() {
    document.getElementById('mobile-menu').classList.toggle('hidden');
  });
</script>

<main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">