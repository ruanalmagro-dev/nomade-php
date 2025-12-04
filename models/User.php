<?php
class User {
    private $pdo;

    public function __construct() {
        $this->pdo = Database::connect();
    }

    public function login($email, $password) {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($user && password_verify($password, $user['password'])) {
            unset($user['password']);
            return $user;
        }
        return false;
    }

    public function register($data) {
        $check = $this->pdo->prepare("SELECT id FROM users WHERE email = ?");
        $check->execute([$data['email']]);
        if ($check->rowCount() > 0) return false;

        $hash = password_hash($data['password'], PASSWORD_DEFAULT);
        $stmt = $this->pdo->prepare("INSERT INTO users (name, cpf, address, email, password, type) VALUES (?, ?, ?, ?, ?, ?)");
        return $stmt->execute([$data['name'], $data['cpf'], $data['address'], $data['email'], $hash, $data['type']]);
    }
}