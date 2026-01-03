<?php
// controllers/DirectionsController.php
require_once __DIR__ . '/../models/Direction.php';
$dirModel = new Direction($pdo);
if ($action === 'list') {
    $directions = $dirModel->all();
    require __DIR__ . '/../views/directions/list.php';
} elseif ($action === 'create') {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $dirModel->create($_POST['name']);
        header('Location: index.php?page=directions');
        exit;
    }
    require __DIR__ . '/../views/directions/form.php';
} elseif ($action === 'edit') {
    $id = $_GET['id'] ?? null;
    if (!$id) { header('Location: index.php?page=directions'); exit; }
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $dirModel->update($id, $_POST['name']);
        header('Location: index.php?page=directions');
        exit;
    }
    $direction = $dirModel->find($id);
    require __DIR__ . '/../views/directions/form.php';
} elseif ($action === 'delete') {
    $id = $_GET['id'] ?? null;
    if ($id) { $dirModel->delete($id); }
    header('Location: index.php?page=directions');
    exit;
} else {
    echo 'Action not allowed';
}
?>