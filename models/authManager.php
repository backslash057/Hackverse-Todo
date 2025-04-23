<?php

class AuthManager {
    protected $db;

    public function __construct() {
        $host = "localhost";
        $dbname = "todo_db";
        $username = "root";
        $password = "";

        $this->db = new PDO("mysql:host={$host};dbname={$dbname};charset=utf8", $username, $password);
        $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function createUser($names, $surnames, $email, $phone, $birth_date, $gender, $role, $password) {
        $hashed = password_hash($password, PASSWORD_BCRYPT);

        $stmt = $this->db->prepare("
            INSERT INTO Users(names, surnames, email, phone, birth_date, gender, role, password)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)
        ");
        $stmt->execute([
            $names, $surnames, $email, $phone, $birth_date, $gender, $role, $hashed
        ]);

        return $this->db->lastInsertId();
    }

    public function getUserByEmail($email) {
        $stmt = $this->db->prepare("SELECT user_id,  names, surnames, email, phone, birth_date, gender, role FROM Users WHERE email = ?");
        $stmt->execute([$email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function checkUser($email, $password) {
        $stmt = $this->db->prepare("SELECT password FROM Users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        
        return $user && password_verify($password, $user['password']);
    }
}
?>