<?php

require_once $_SERVER["DOCUMENT_ROOT"] . "/config.php";

class AuthManager {
    protected $db;

    public function __construct() {
        $this->db = new PDO(
            "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8",
            DB_USER,
            DB_PASS
        );
        $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function createUser($names, $surnames, $email, $phone, $birth_date, $gender, $password) {
        $hashed = password_hash($password, PASSWORD_BCRYPT);

        $stmt = $this->db->prepare("
            INSERT INTO users(names, surnames, email, phone, birth_date, gender, password)
            VALUES (?, ?, ?, ?, ?, ?, ?)
        ");
        $stmt->execute([
            $names, $surnames, $email, $phone, $birth_date, $gender, $hashed
        ]);

        return $this->db->lastInsertId();
    }

    public function getUserByEmail($email) {
        $stmt = $this->db->prepare("SELECT user_id,  names, surnames, email, phone, birth_date, gender FROM users WHERE email = ?");
        $stmt->execute([$email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function checkUser($email, $password) {
        $stmt = $this->db->prepare("SELECT password FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        
        return $user && password_verify($password, $user['password']);
    }
}
?>