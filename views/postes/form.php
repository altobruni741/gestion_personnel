<div class="max-w-2xl mx-auto px-4 py-8">
  <!-- Header -->
  <div class="mb-8">
    <h1 class="text-3xl font-bold text-slate-900 dark:text-white">
      <?=isset($edit_mode) ? 'Modifier le poste' : 'Créer un poste'?>
    </h1>
    <p class="text-slate-600 dark:text-slate-400 mt-2">Remplissez le formulaire ci-dessous</p>
  </div>

  <!-- Erreur -->
  <?php if (isset($error)): ?>
    <div class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg p-4 mb-6">
      <p class="text-red-900 dark:text-red-100"><?=h($error)?></p>
    </div>
  <?php endif; ?>

  <!-- Formulaire -->
  <form method="POST" class="bg-white dark:bg-slate-800 rounded-lg shadow p-6 space-y-6">
    <fieldset class="border border-slate-200 dark:border-slate-700 rounded-lg p-4">
      <legend class="text-lg font-semibold text-slate-900 dark:text-white px-2">Informations générales</legend>
      
      <div class="mt-4 space-y-4">
        <div>
          <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Nom du poste *</label>
          <input type="text" name="name" value="<?=h($poste['name'] ?? '')?>" required class="w-full px-4 py-2 border border-slate-300 dark:border-slate-600 rounded-lg dark:bg-slate-700 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent">
        </div>
        
        <div>
          <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Description</label>
          <textarea name="description" rows="3" class="w-full px-4 py-2 border border-slate-300 dark:border-slate-600 rounded-lg dark:bg-slate-700 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent"><?=h($poste['description'] ?? '')?></textarea>
        </div>
      </div>
    </fieldset>

    <fieldset class="border border-slate-200 dark:border-slate-700 rounded-lg p-4">
      <legend class="text-lg font-semibold text-slate-900 dark:text-white px-2">Hiérarchie</legend>
      
      <div class="mt-4 space-y-4">
        <div>
          <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Direction *</label>
          <select id="direction_select" class="w-full px-4 py-2 border border-slate-300 dark:border-slate-600 rounded-lg dark:bg-slate-700 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            <option value="">-- Sélectionnez une direction --</option>
            <?php foreach ($directions as $d): ?>
              <option value="<?=$d['id']?>" <?=(isset($poste) && $poste['direction_id'] == $d['id']) ? 'selected' : ''?>>
                <?=h($d['name'])?>
              </option>
            <?php endforeach; ?>
          </select>
        </div>
        
        <div>
          <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Service *</label>
          <select name="service_id" id="service_select" required class="w-full px-4 py-2 border border-slate-300 dark:border-slate-600 rounded-lg dark:bg-slate-700 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            <option value="">-- Sélectionnez un service --</option>
            <?php 
              $current_service_id = isset($poste) ? $poste['service_id'] : null;
              foreach ($services as $s): 
            ?>
              <option value="<?=$s['id']?>" data-direction="<?=$s['direction_id']?>" <?=$current_service_id == $s['id'] ? 'selected' : ''?>>
                <?=h($s['name'])?>
              </option>
            <?php endforeach; ?>
          </select>
        </div>
      </div>
    </fieldset>

    <!-- Actions -->
    <div class="flex gap-4">
      <button type="submit" class="flex-1 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition">
        <?=isset($edit_mode) ? 'Mettre à jour' : 'Créer'?>
      </button>
      <a href="index.php?page=poste&action=list" class="flex-1 px-4 py-2 bg-slate-200 hover:bg-slate-300 dark:bg-slate-700 dark:hover:bg-slate-600 text-slate-900 dark:text-white font-medium rounded-lg text-center transition">
        Annuler
      </a>
    </div>
  </form>
</div>

<script>
  // Filtrage en cascadedu service par direction
  document.getElementById('direction_select').addEventListener('change', function() {
    const directionId = this.value;
    const serviceSelect = document.getElementById('service_select');
    
    Array.from(serviceSelect.options).forEach(option => {
      if (option.value === '') {
        option.style.display = '';
      } else {
        option.style.display = (option.getAttribute('data-direction') === directionId) ? '' : 'none';
      }
    });
    
    serviceSelect.value = '';
  });
  
  // Initialiser le filtrage si une direction est déjà sélectionnée
  if (document.getElementById('direction_select').value) {
    document.getElementById('direction_select').dispatchEvent(new Event('change'));
  }
</script>
