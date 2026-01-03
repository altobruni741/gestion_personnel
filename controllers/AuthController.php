<?php
// controllers/AuthController.php
require_once __DIR__ . '/../models/User.php';
$userModel = new User($pdo);
if ($action === 'login') {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $username = $_POST['username'] ?? '';
        $password = $_POST['password'] ?? '';
        $u = $userModel->findByUsername($username);
        if ($u && password_verify($password, $u['password_hash'])) {
            $_SESSION['user_id'] = $u['id'];
            $_SESSION['username'] = $u['username'];
            header('Location: index.php'); exit;
        } else {
            $error = 'Nom d\'utilisateur ou mot de passe incorrect';
        }
    }
    require __DIR__ . '/../views/auth/login.php';
} elseif ($action === 'register') {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $username = trim($_POST['username'] ?? '');
        $password = $_POST['password'] ?? '';
        $password2 = $_POST['password2'] ?? '';
        if ($username === '' || $password === '') {
            $error = 'Tous les champs sont requis';
        } elseif ($password !== $password2) {
            $error = 'Les mots de passe ne correspondent pas';
        } else {
            if ($userModel->findByUsername($username)) {
                $error = 'Nom d\'utilisateur déjà pris';
            } else {
                $hash = password_hash($password, PASSWORD_DEFAULT);
                $userModel->create($username, $hash);
                header('Location: index.php?page=auth&action=login'); exit;
            }
        }
    }
    require __DIR__ . '/../views/auth/register.php';
} elseif ($action === 'logout') {
    session_unset();
    session_destroy();
    header('Location: index.php?page=auth&action=login'); exit;
} else {
    echo 'Action not allowed';
}
?>