<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/models/taskManager.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/models/authManager.php';

class TaskController {
    private $taskModel;
    private $auth;

    public function __construct($pdo) {
        $this->taskModel = new TaskManager();
        $this->auth = new AuthManager();
    }

    public function handleRequest() {
        // Authenticate user by JWT
        $jwt = $this->getBearerToken();
        $userId = $this->auth->validateJWT($jwt);

        if (!$userId) {
            echo json_encode(['error' => 'Unauthorized']);
            return;
        }

        $method = $_SERVER['REQUEST_METHOD'];

        switch ($method) {
            case 'GET':
                if (isset($_GET['id'])) {
                    echo json_encode($this->taskModel->getTask($_GET['id'], $userId));
                } else {
                    echo json_encode($this->taskModel->getAllTasks($userId));
                }
                break;

            case 'POST':
                $data = json_decode(file_get_contents('php://input'), true);
                if (isset($data['title'])) {
                    $this->taskModel->addTask($data['title'], $userId);
                    echo json_encode(['message' => 'Task added']);
                }
                break;

            case 'PUT':
                parse_str(file_get_contents('php://input'), $data);
                if (isset($data['id'], $data['status'])) {
                    $this->taskModel->updateTask($data['id'], $data['status'], $userId);
                    echo json_encode(['message' => 'Task updated']);
                }
                break;

            case 'DELETE':
                parse_str(file_get_contents('php://input'), $data);
                if (isset($data['id'])) {
                    $this->taskModel->deleteTask($data['id'], $userId);
                    echo json_encode(['message' => 'Task deleted']);
                }
                break;

            default:
                http_response_code(405);
                echo json_encode(['error' => 'Method Not Allowed']);
                break;
        }
    }

    // Helper function to extract the JWT from the Authorization header
    private function getBearerToken() {
        $headers = apache_request_headers();
        if (isset($headers['Authorization'])) {
            return str_replace('Bearer ', '', $headers['Authorization']);
        }

        return null;
    }
}
?>
