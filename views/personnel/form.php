<?php require __DIR__ . '/../layout/header.php'; ?>

<div class="max-w-4xl mx-auto">
  <div class="bg-white dark:bg-slate-800 rounded-lg shadow-lg p-8">
    <div class="mb-8">
      <h1 class="text-3xl font-bold text-slate-900 dark:text-white">
        <?= isset($person) ? '✏️ Modifier un employé' : '➕ Ajouter un employé' ?>
      </h1>
      <p class="text-slate-600 dark:text-slate-400 mt-2">Complétez le formulaire ci-dessous</p>
    </div>

    <?php if (!empty($error)): ?>
      <div class="mb-6 p-4 rounded-lg bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800">
        <div class="flex gap-3">
          <svg class="w-5 h-5 text-red-600 dark:text-red-400 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
          </svg>
          <p class="text-red-700 dark:text-red-300"><?=h($error)?></p>
        </div>
      </div>
    <?php endif; ?>

    <form method="post" class="space-y-8">
      <?php if (!empty($needsContractMigration)): ?>
        <div class="p-4 rounded-lg bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-800">
          <p class="text-sm text-yellow-800 dark:text-yellow-300">Les colonnes `contract_duration` et `contract_end` sont manquantes. Exécuter la migration pour activer le champ durée du contrat.</p>
          <form method="post" action="migrate_contracts.php" onsubmit="return confirm('Exécuter la migration des contrats maintenant ? Sauvegardez votre base avant.')">
            <button type="submit" class="mt-2 px-4 py-2 bg-yellow-600 hover:bg-yellow-700 text-white rounded-md">Exécuter la migration des contrats</button>
            <a href="index.php?page=personnel" class="ml-3 text-sm text-slate-600 dark:text-slate-300">Retour</a>
          </form>
        </div>
      <?php endif; ?>
      <!-- Section Identité -->
      <fieldset class="border border-slate-200 dark:border-slate-700 rounded-lg p-6">
        <legend class="text-lg font-bold text-slate-900 dark:text-white px-2">👤 Informations Personnelles</legend>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-4">
          <div>
            <label class="block text-sm font-semibold text-slate-900 dark:text-white mb-2">Prénom <span class="text-red-500">*</span></label>
            <input type="text" name="firstname" value="<?= h($person['firstname']) ?>" required class="w-full px-4 py-2 border border-slate-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-700 text-slate-900 dark:text-white placeholder-slate-400 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors" placeholder="Jean">
          </div>
          <div>
            <label class="block text-sm font-semibold text-slate-900 dark:text-white mb-2">Nom <span class="text-red-500">*</span></label>
            <input type="text" name="lastname" value="<?= h($person['lastname']) ?>" required class="w-full px-4 py-2 border border-slate-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-700 text-slate-900 dark:text-white placeholder-slate-400 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors" placeholder="Dupont">
          </div>
          <div>
            <label class="block text-sm font-semibold text-slate-900 dark:text-white mb-2">Email</label>
            <input type="email" name="email" value="<?= h($person['email'] ?? '') ?>" class="w-full px-4 py-2 border border-slate-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-700 text-slate-900 dark:text-white placeholder-slate-400 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors" placeholder="jean@example.com">
          </div>
          <div>
            <label class="block text-sm font-semibold text-slate-900 dark:text-white mb-2">Téléphone</label>
            <input type="tel" name="phone" value="<?= h($person['phone'] ?? '') ?>" class="w-full px-4 py-2 border border-slate-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-700 text-slate-900 dark:text-white placeholder-slate-400 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors" placeholder="+33 1 23 45 67 89">
          </div>
        </div>
      </fieldset>

      <!-- Section Poste -->
      <fieldset class="border border-slate-200 dark:border-slate-700 rounded-lg p-6">
        <legend class="text-lg font-bold text-slate-900 dark:text-white px-2">💼 Poste et Organisation</legend>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-4">
          <div>
            <label class="block text-sm font-semibold text-slate-900 dark:text-white mb-2">Direction</label>
            <select name="direction_id" id="direction_id" class="w-full px-4 py-2 border border-slate-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-700 text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors">
              <option value="">-- Sélectionner une direction --</option>
              <?php foreach($directions as $d): ?>
              <option value="<?=h($d['id'])?>" <?= $person['direction_id']==$d['id'] ? 'selected':'' ?>><?=h($d['name'])?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div>
            <label class="block text-sm font-semibold text-slate-900 dark:text-white mb-2">Service</label>
            <select name="service_id" id="service_id" class="w-full px-4 py-2 border border-slate-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-700 text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors">
              <option value="">-- Sélectionner un service --</option>
              <?php foreach($services as $s): ?>
                <option value="<?=h($s['id'])?>" data-direction="<?=h($s['direction_id'])?>" <?= $person['service_id']==$s['id'] ? 'selected':'' ?>><?=h($s['name'])?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div>
            <label class="block text-sm font-semibold text-slate-900 dark:text-white mb-2">Poste</label>
            <select name="poste_id" id="poste_id" class="w-full px-4 py-2 border border-slate-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-700 text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors">
              <option value="">-- Sélectionner un poste --</option>
            </select>
          </div>
        </div>
        <div class="mt-4">
          <label class="block text-sm font-semibold text-slate-900 dark:text-white mb-2">Position (libre texte, optionnel)</label>
            <input type="text" name="position" value="<?= h($person['position'] ?? '') ?>" class="w-full px-4 py-2 border border-slate-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-700 text-slate-900 dark:text-white placeholder-slate-400 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors" placeholder="ex: Responsable de Projet (surcharge le nom du poste)">
        </div>
      </fieldset>

      <!-- Section Statut et Emploi -->
      <fieldset class="border border-slate-200 dark:border-slate-700 rounded-lg p-6">
        <legend class="text-lg font-bold text-slate-900 dark:text-white px-2">📋 Statut et Emploi</legend>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-4">
          <div>
            <label class="block text-sm font-semibold text-slate-900 dark:text-white mb-2">Statut</label>
            <select name="status" class="w-full px-4 py-2 border border-slate-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-700 text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors">
              <option value="Actif" <?= $person['status'] === 'Actif' ? 'selected' : '' ?>>Actif</option>
              <option value="Inactif" <?= $person['status'] === 'Inactif' ? 'selected' : '' ?>>Inactif</option>
              <option value="En Congé" <?= $person['status'] === 'En Congé' ? 'selected' : '' ?>>En Congé</option>
              <option value="Retraité" <?= $person['status'] === 'Retraité' ? 'selected' : '' ?>>Retraité</option>
            </select>
          </div>
          <div>
            <label class="block text-sm font-semibold text-slate-900 dark:text-white mb-2">Date d'embauche</label>
            <input type="date" name="hire_date" value="<?= h($person['hire_date'] ?? '') ?>" class="w-full px-4 py-2 border border-slate-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-700 text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors">
          </div>
          <div>
            <label class="block text-sm font-semibold text-slate-900 dark:text-white mb-2">Salaire mensuel</label>
            <input type="number" name="salary" value="<?= h($person['salary'] ?? '') ?>" step="0.01" class="w-full px-4 py-2 border border-slate-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-700 text-slate-900 dark:text-white placeholder-slate-400 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors" placeholder="0.00">
          </div>
          <div>
            <label class="block text-sm font-semibold text-slate-900 dark:text-white mb-2">Durée du contrat (jours)</label>
            <input type="number" min="0" name="contract_duration" id="contract_duration" value="<?= isset($person['contract_duration']) && $person['contract_duration'] ? (int)$person['contract_duration'] : '' ?>" class="w-full px-4 py-2 border border-slate-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-700 text-slate-900 dark:text-white placeholder-slate-400 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors" placeholder="Nombre de jours">
          </div>
          <div>
            <label class="block text-sm font-semibold text-slate-900 dark:text-white mb-2">Fin de contrat</label>
            <input type="date" name="contract_end" id="contract_end" value="<?= h($person['contract_end'] ?? '') ?>" readonly class="w-full px-4 py-2 border border-slate-300 dark:border-slate-600 rounded-lg bg-slate-50 dark:bg-slate-700/40 text-slate-900 dark:text-white placeholder-slate-400 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors">
          </div>
        </div>
      </fieldset>

      <!-- Section Notes -->
      <fieldset class="border border-slate-200 dark:border-slate-700 rounded-lg p-6">
        <legend class="text-lg font-bold text-slate-900 dark:text-white px-2">📝 Notes et Remarques</legend>
        <div class="mt-4">
          <textarea name="notes" rows="4" class="w-full px-4 py-2 border border-slate-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-700 text-slate-900 dark:text-white placeholder-slate-400 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors" placeholder="Remarques supplémentaires..."><?= h($person['notes'] ?? '') ?></textarea>
        </div>
      </fieldset>

      <!-- Actions -->
      <div class="flex gap-4 pt-4">
        <button type="submit" class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors flex items-center gap-2">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
          </svg>
          <?= isset($person) ? 'Mettre à jour' : 'Créer' ?>
        </button>
        <a href="index.php?page=personnel" class="px-6 py-3 bg-slate-300 dark:bg-slate-700 hover:bg-slate-400 dark:hover:bg-slate-600 text-slate-900 dark:text-white font-medium rounded-lg transition-colors">
          Annuler
        </a>
      </div>
    </form>
  </div>
</div>

<?php require __DIR__ . '/../layout/footer.php'; ?>
<script>
  (function(){
    // Cascade: Direction → Service → Poste
    const dirSelect = document.getElementById('direction_id');
    const svcSelect = document.getElementById('service_id');
    const posteSelect = document.getElementById('poste_id');
    const hire = document.querySelector('input[name="hire_date"]');
    const duration = document.getElementById('contract_duration');
    const end = document.getElementById('contract_end');

    function filterServices() {
      const dirId = dirSelect.value;
      
      // Filter service options based on direction
      const allOptions = Array.from(svcSelect.querySelectorAll('option'));
      allOptions.forEach(opt => {
        if (opt.value === '') {
          opt.style.display = '';
        } else {
          const svcDir = opt.getAttribute('data-direction');
          opt.style.display = (!dirId || svcDir == dirId) ? '' : 'none';
        }
      });
      
      // Clear service if it's now hidden
      const currentOpt = svcSelect.querySelector(`option[value="${svcSelect.value}"]`);
      if (currentOpt && currentOpt.style.display === 'none') {
        svcSelect.value = '';
      }
      
      filterPostes();
    }

    function filterPostes() {
      const svcId = svcSelect.value;
      
      if (!svcId) {
        posteSelect.innerHTML = '<option value="">-- Sélectionner un poste --</option>';
        return;
      }
      
      // Fetch postes for this service via AJAX
      fetch('api/get_postes.php?service_id=' + encodeURIComponent(svcId))
        .then(res => res.json())
        .then(data => {
          if (data.success && data.postes) {
            posteSelect.innerHTML = '<option value="">-- Sélectionner un poste --</option>';
            data.postes.forEach(poste => {
              const opt = document.createElement('option');
              opt.value = poste.id;
              opt.textContent = poste.name;
              <?php if (isset($person) && !empty($person['poste_id'])): ?>
                if (poste.id == <?= (int)$person['poste_id'] ?>) opt.selected = true;
              <?php endif; ?>
              posteSelect.appendChild(opt);
            });
          }
        })
        .catch(err => console.error('Error loading postes:', err));
    }

    function computeEnd(){
      if(!hire || !duration || !end) return;
      const hd = hire.value;
      const d = parseInt(duration.value || 0, 10);
      if(hd && d>0){
        const dt = new Date(hd);
        dt.setDate(dt.getDate() + d);
        const yyyy = dt.getFullYear();
        const mm = String(dt.getMonth()+1).padStart(2,'0');
        const dd = String(dt.getDate()).padStart(2,'0');
        end.value = `${yyyy}-${mm}-${dd}`;
      }
    }

    if(dirSelect) dirSelect.addEventListener('change', filterServices);
    if(svcSelect) svcSelect.addEventListener('change', filterPostes);
    if(hire) hire.addEventListener('change', computeEnd);
    if(duration) duration.addEventListener('input', computeEnd);
    
    // init on load
    computeEnd();
    filterServices();
  })();
</script>