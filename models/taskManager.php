<?php

require_once $_SERVER["DOCUMENT_ROOT"] . "/config.php";

class TaskManager {
    protected $db;

    public function __construct() {
        $this->db = new PDO(
            "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8",
            DB_USER,
            DB_PASS
        );
        $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function getAllTasks($userId) {
        $stmt = $this->db->prepare('SELECT * FROM tasks WHERE user_id = ? ORDER BY created_at DESC');
        $stmt->execute([$userId]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getTask($id, $userId) {
        $stmt = $this->db->prepare('SELECT * FROM tasks WHERE id = ? AND user_id = ?');
        $stmt->execute([$id, $userId]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function addTask($title, $userId) {
        $stmt = $this->db->prepare('INSERT INTO tasks (title, user_id) VALUES (?, ?)');

        return $stmt->execute([$title, $userId]);
    }

    public function updateTask($id, $status, $userId) {
        $stmt = $this->db->prepare('UPDATE tasks SET status = ? WHERE id = ? AND user_id = ?');

        return $stmt->execute([$status, $id, $userId]);
    }

    public function deleteTask($id, $userId) {
        $stmt = $this->db->prepare('DELETE FROM tasks WHERE id = ? AND user_id = ?');

        return $stmt->execute([$id, $userId]);
    }
}
?>
