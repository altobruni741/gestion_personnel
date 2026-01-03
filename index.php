<?php
/**
 * Gestion du Personnel - Application moderne
 * Routeur simple via param 'page' et 'action'
 */

session_start();

// Configuration et connexion BD
require_once __DIR__ . '/config/db.php';

// Helpers de sécurité
function h($s) { 
    return htmlspecialchars($s, ENT_QUOTES, 'UTF-8'); 
}

// Logging simple
function log_action($message) {
    $log_file = __DIR__ . '/logs/app.log';
    if (!is_dir(__DIR__ . '/logs')) mkdir(__DIR__ . '/logs', 0755, true);
    file_put_contents($log_file, date('Y-m-d H:i:s') . " - $message\n", FILE_APPEND);
}

// Gestion des erreurs
error_reporting(E_ALL);
ini_set('display_errors', 0);
set_error_handler(function($errno, $errstr, $errfile, $errline) {
    log_action("ERROR: $errstr in $errfile:$errline");
    http_response_code(500);
    include __DIR__ . '/views/layout/header.php';
    echo '<div class="max-w-2xl mx-auto mt-8"><div class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg p-6"><h1 class="text-xl font-bold text-red-900 dark:text-red-100 mb-2">Une erreur est survenue</h1><p class="text-red-800 dark:text-red-200 mb-4">Une erreur interne s\'est produite. Veuillez réessayer plus tard.</p><p class="text-sm text-red-700 dark:text-red-300">Si le problème persiste, vous devrez peut-être effectuer une migration: <a href="setup.php" class="underline font-semibold">Cliquez ici pour la migration</a></p></div></div>';
    include __DIR__ . '/views/layout/footer.php';
    return true;
});

// Paramètres de routage
$page = $_GET['page'] ?? 'directions';
$action = $_GET['action'] ?? 'list';

$base = __DIR__;

// Pages autorisées
$allowed_pages = ['directions', 'services', 'poste', 'personnel', 'auth'];
if (!in_array($page, $allowed_pages)) { 
    $page = 'directions'; 
}

// Protection des routes: seules les pages auth sont accessibles sans connexion
if (!isset($_SESSION['user_id']) && $page !== 'auth') {
    header('Location: index.php?page=auth&action=login');
    exit;
}

// Inclusion du contrôleur
$controller_file = $base . '/controllers/' . ucfirst($page) . 'Controller.php';
if (file_exists($controller_file)) {
    require $controller_file;
    log_action("Accessed: $page - $action");
} else {
    http_response_code(404);
    require __DIR__ . '/views/layout/header.php';
    echo '<div class="max-w-2xl mx-auto mt-8"><div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-6"><h1 class="text-xl font-bold text-blue-900 dark:text-blue-100 mb-2">Page non trouvée</h1><p class="text-blue-800 dark:text-blue-200">La page que vous cherchez n\'existe pas.</p><a href="index.php?page=directions" class="inline-block mt-4 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg">Retour à l\'accueil</a></div></div>';
    require __DIR__ . '/views/layout/footer.php';
}
?>