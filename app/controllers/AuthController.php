<?php

class AuthController
{
    private $users;

    public function __construct($db)
    {
        $this->users = $db->users;
    }

    public function login()
    {
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';

        $user = $this->users->findOne([
            'email' => $email,
            'role' => 'admin'
        ]);

        if (
            $user &&
            password_verify($password, $user['password'])
        ) {
            session_regenerate_id(true);

            $_SESSION['admin_id'] = (string) $user['_id'];
            $_SESSION['admin_name'] = $user['name'];

            header('Location: ?page=dashboard');
            exit;
        }

        return 'Email atau password salah.';
    }

    public function logout()
    {
        $_SESSION = [];

        session_destroy();

        header('Location: ?page=login');
        exit;
    }
}