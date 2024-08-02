<?php

class Register
{
    private $pdo;
    
    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function registerUser($name, $email, $number, $password, $confirmPassword)
    {
        $name = filter_var($name, FILTER_SANITIZE_STRING);
        $email = filter_var($email, FILTER_SANITIZE_EMAIL);
        $number = filter_var($number, FILTER_SANITIZE_STRING);
        $password = filter_var($password, FILTER_SANITIZE_STRING);
        $confirmPassword = filter_var($confirmPassword, FILTER_SANITIZE_STRING);

        $passwordHash = password_hash($password, PASSWORD_DEFAULT);
        $confirmPasswordHash = password_hash($confirmPassword, PASSWORD_DEFAULT);

        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE email = ? OR number = ?");
        $stmt->execute([$email, $number]);

        if ($stmt->rowCount() > 0) {
            return 'Email or number already exists!';
        } elseif ($password !== $confirmPassword) {
            return 'Confirm password does not match!';
        } else {
            $stmt = $this->pdo->prepare("INSERT INTO users (name, email, number, password) VALUES (?, ?, ?, ?)");
            $stmt->execute([$name, $email, $number, $passwordHash]);

            // Automatically log the user in after registration
            $stmt = $this->pdo->prepare("SELECT * FROM users WHERE email = ? AND password = ?");
            $stmt->execute([$email, $passwordHash]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($stmt->rowCount() > 0) {
                return ['success' => true, 'user_id' => $user['id']];
            }
        }

        return 'Registration failed!';
    }
}
