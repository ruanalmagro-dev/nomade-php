<?php
class AuthController {
    public function login() {
        require 'views/login.php';
    }

    public function register() {
        require 'views/register.php';
    }

    public function logout() {
        session_destroy();
        header('Location: home');
    }

    public function handleAction() {
        $action = $_POST['action'] ?? '';
        $userModel = new User();

        if ($action === 'login') {
            $user = $userModel->login($_POST['email'], $_POST['password']);
            if ($user) {
                $_SESSION['user'] = $user;
                header('Location: perfil');
            } else {
                header('Location: login?error=credenciais');
            }
        } elseif ($action === 'register') {
            
            if ($_POST['password'] !== $_POST['password_confirm']) {
                header('Location: register?error=pass_mismatch');
                exit;
            }

            $data = [
                'name' => $_POST['name'],
                'cpf' => $_POST['cpf'],
                'address' => $_POST['address'],
                'email' => $_POST['email'],
                'password' => $_POST['password'],
                'type' => $_POST['type']
            ];

            $success = $userModel->register($data);

            if ($success) {
                header('Location: login?success=created');
            } else {
                header('Location: register?error=exists');
            }
        } else {
            header('Location: home');
        }
    }
}