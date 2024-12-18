<?php
namespace controllers;

use models\User;
use config\Database; // Add this line to import the Database class

session_start();

class UserController {
    private $userModel;

    public function __construct(User $user) {
        $this->userModel = $user;
    }

    public function register() {
        // Lógica para registrar un usuario
        $username = $_POST['name']; // Change to match the form field name
        $email = $_POST['email']; // Change to match the form field name
        $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
        if ($this->userModel->createUser($username, $email, $password)) { // Adjust method call to match parameters
            header("Location: /blog/views/home/home.php");
            exit();
        } else {
            echo "Error al registrar el usuario.";
        }
    }

    public function login() {
        // Lógica para iniciar sesión de un usuario
        $email = $_POST['email'];
        $password = $_POST['password'];
        $user = $this->userModel->getUserByEmail($email);
        if ($user) {
            if ($user['blocked'] == 1) {
                return ["blocked" => "Tu cuenta ha sido bloqueada. Por favor, contacta al administrador."];
            }
            if (password_verify($password, $user['password'])) {
                $_SESSION['user'] = $user;
                header("Location: /blog/views/home/home.php");
                exit();
            }
        }
        return ["Correo electrónico o contraseña incorrectos."];
    }

    public function logout() {
        // Lógica para cerrar sesión de un usuario
        session_destroy();
        header("Location: /blog/views/Auth/logout.php");
        exit();
    }
}

