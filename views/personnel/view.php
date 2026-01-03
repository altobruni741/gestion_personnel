<?php require __DIR__ . '/../layout/header.php'; ?>

<?php if (!$person): ?>
  <div class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg p-6 text-center">
    <p class="text-red-600 dark:text-red-400">Employé non trouvé</p>
    <a href="index.php?page=personnel" class="text-blue-600 dark:text-blue-400 hover:underline mt-2 inline-block">Retour à la liste</a>
  </div>
<?php else: ?>

<div class="space-y-6">
  <!-- En-tête -->
  <div class="bg-white dark:bg-slate-800 rounded-lg shadow-lg p-8">
    <div class="flex justify-between items-start mb-6">
      <div>
        <h1 class="text-3xl font-bold text-slate-900 dark:text-white"><?=h($person['firstname'] . ' ' . $person['lastname'])?></h1>
        <div class="flex flex-wrap gap-2 mt-3">
          <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 dark:bg-blue-900/30 text-blue-800 dark:text-blue-300">
            <?=h($person['position'] ?? 'Sans poste')?>
          </span>
          <?php
            $statusClass = $person['status'] === 'Actif' ? 'bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-300' : 
                          ($person['status'] === 'En Congé' ? 'bg-yellow-100 dark:bg-yellow-900/30 text-yellow-800 dark:text-yellow-300' : 
                          'bg-red-100 dark:bg-red-900/30 text-red-800 dark:text-red-300');
          ?>
          <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium <?=$statusClass?>">
            <?=h($person['status'] ?? 'Statut inconnu')?>
          </span>
        </div>
      </div>
      <div class="flex gap-2">
        <a href="index.php?page=personnel&action=edit&id=<?=h($person['id'])?>" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors flex items-center gap-2">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
          </svg>
          Éditer
        </a>
        <a href="index.php?page=personnel&action=delete&id=<?=h($person['id'])?>" onclick="return confirm('Êtes-vous sûr ?')" class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white font-medium rounded-lg transition-colors flex items-center gap-2">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
          </svg>
          Supprimer
        </a>
      </div>
    </div>
  </div>

  <!-- Informations principales -->
  <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <!-- Contact -->
    <div class="bg-white dark:bg-slate-800 rounded-lg shadow p-6">
      <h2 class="text-xl font-bold text-slate-900 dark:text-white mb-4 flex items-center gap-2">
        <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
        </svg>
        Contact
      </h2>
      <div class="space-y-3">
        <?php if ($person['email']): ?>
          <div>
            <p class="text-sm text-slate-600 dark:text-slate-400">Email</p>
            <a href="mailto:<?=h($person['email'])?>" class="text-blue-600 dark:text-blue-400 hover:underline font-medium"><?=h($person['email'])?></a>
          </div>
        <?php endif; ?>
        <?php if ($person['phone']): ?>
          <div>
            <p class="text-sm text-slate-600 dark:text-slate-400">Téléphone</p>
            <a href="tel:<?=h($person['phone'])?>" class="text-blue-600 dark:text-blue-400 hover:underline font-medium"><?=h($person['phone'])?></a>
          </div>
        <?php endif; ?>
      </div>
    </div>

    <!-- Organisation -->
    <div class="bg-white dark:bg-slate-800 rounded-lg shadow p-6">
      <h2 class="text-xl font-bold text-slate-900 dark:text-white mb-4 flex items-center gap-2">
        <svg class="w-6 h-6 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5.581m0 0H9m0 0h-.581m0 0A2 2 0 105.9 6h.581m0 0a2 2 0 110 4.581m0-6.581a6 6 0 1 1-6 6"></path>
        </svg>
        Organisation
      </h2>
      <div class="space-y-3">
        <div>
          <p class="text-sm text-slate-600 dark:text-slate-400">Direction</p>
          <p class="font-medium text-slate-900 dark:text-white"><?=h($person['direction_name'] ?? 'Non assignée')?></p>
        </div>
        <div>
          <p class="text-sm text-slate-600 dark:text-slate-400">Service</p>
          <p class="font-medium text-slate-900 dark:text-white"><?=h($person['service_name'] ?? 'Non assigné')?></p>
        </div>
      </div>
    </div>

    <!-- Employé -->
    <div class="bg-white dark:bg-slate-800 rounded-lg shadow p-6">
      <h2 class="text-xl font-bold text-slate-900 dark:text-white mb-4 flex items-center gap-2">
        <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
        </svg>
        Informations Emploi
      </h2>
      <div class="space-y-3">
        <?php if ($person['hire_date']): ?>
          <div>
            <p class="text-sm text-slate-600 dark:text-slate-400">Date d'embauche</p>
            <p class="font-medium text-slate-900 dark:text-white"><?=date('d/m/Y', strtotime($person['hire_date']))?></p>
          </div>
        <?php endif; ?>
        <?php if ($person['salary']): ?>
          <div>
            <p class="text-sm text-slate-600 dark:text-slate-400">Salaire</p>
            <p class="font-medium text-slate-900 dark:text-white"><?=number_format($person['salary'], 0, ',', ' ')?> €</p>
          </div>
        <?php endif; ?>
      </div>
    </div>

    <!-- Création -->
    <div class="bg-white dark:bg-slate-800 rounded-lg shadow p-6">
      <h2 class="text-xl font-bold text-slate-900 dark:text-white mb-4 flex items-center gap-2">
        <svg class="w-6 h-6 text-slate-600 dark:text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
        </svg>
        Historique
      </h2>
      <div class="space-y-3">
        <div>
          <p class="text-sm text-slate-600 dark:text-slate-400">Enregistré le</p>
          <p class="font-medium text-slate-900 dark:text-white"><?=date('d/m/Y H:i', strtotime($person['created_at']))?></p>
        </div>
        <div>
          <p class="text-sm text-slate-600 dark:text-slate-400">Mis à jour le</p>
          <p class="font-medium text-slate-900 dark:text-white"><?=date('d/m/Y H:i', strtotime($person['updated_at']))?></p>
        </div>
      </div>
    </div>
  </div>

  <!-- Notes -->
  <?php if ($person['notes']): ?>
    <div class="bg-yellow-50 dark:bg-yellow-900/20 border-l-4 border-yellow-400 dark:border-yellow-600 rounded p-6">
      <h2 class="text-lg font-bold text-yellow-900 dark:text-yellow-100 mb-2">📝 Notes</h2>
      <p class="text-yellow-800 dark:text-yellow-200 whitespace-pre-wrap"><?=h($person['notes'])?></p>
    </div>
  <?php endif; ?>

  <!-- Retour -->
  <div class="flex gap-2">
    <a href="index.php?page=personnel" class="px-4 py-2 bg-slate-300 dark:bg-slate-700 hover:bg-slate-400 dark:hover:bg-slate-600 text-slate-900 dark:text-white font-medium rounded-lg transition-colors">
      ← Retour à la liste
    </a>
  </div>
</div>

<?php endif; ?>

<?php require __DIR__ . '/../layout/footer.php'; ?>
