<?php
require_once __DIR__ . '/../models/Service.php';
require_once __DIR__ . '/../models/Direction.php';
$svcModel = new Service($pdo);
$dirModel = new Direction($pdo);
if ($action === 'list') {
    $services = $svcModel->all();
    $directions = $dirModel->all();
    require __DIR__ . '/../views/services/list.php';
} elseif ($action === 'create') {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $svcModel->create($_POST['name'], $_POST['direction_id']);
        header('Location: index.php?page=services');
        exit;
    }
    $directions = $dirModel->all();
    require __DIR__ . '/../views/services/form.php';
} elseif ($action === 'edit') {
    $id = $_GET['id'] ?? null;
    if (!$id) { header('Location: index.php?page=services'); exit; }
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $svcModel->update($id, $_POST['name'], $_POST['direction_id']);
        header('Location: index.php?page=services'); exit;
    }
    $service = $svcModel->find($id);
    $directions = $dirModel->all();
    require __DIR__ . '/../views/services/form.php';
} elseif ($action === 'delete') {
    $id = $_GET['id'] ?? null;
    if ($id) { $svcModel->delete($id); }
    header('Location: index.php?page=services'); exit;
} else {
    echo 'Action not allowed';
}
?>