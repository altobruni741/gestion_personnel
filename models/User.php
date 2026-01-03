<?php
// models/User.php
class User {
    private $pdo;
    public function __construct($pdo){ $this->pdo = $pdo; }
    public function findByUsername($username){
        $stmt = $this->pdo->prepare('SELECT * FROM users WHERE username = ?');
        $stmt->execute([$username]);
        return $stmt->fetch();
    }
    public function find($id){
        $stmt = $this->pdo->prepare('SELECT * FROM users WHERE id = ?');
        $stmt->execute([$id]);
        return $stmt->fetch();
    }
    public function create($username, $password_hash){
        $stmt = $this->pdo->prepare('INSERT INTO users (username, password_hash, created_at) VALUES (?, ?, NOW())');
        return $stmt->execute([$username, $password_hash]);
    }
}
?>