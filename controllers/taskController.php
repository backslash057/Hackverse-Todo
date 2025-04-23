<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/models/taskManager.php';

require_once $_SERVER["DOCUMENT_ROOT"] . "/controllers/authController.php";

class TaskController {
    private $taskModel;
    private $auth;

    public function __construct() {
        $this->taskModel = new TaskManager();
        $this->auth = new AuthManager();
    }
    

    public function handleRequest() {
        $controller = new Authcontroller();
        $user = $controller->checkAuthentification();


        if (!$user || !$user["user_id"]) {
            return ['error' => 'Unauthorized'];
            return;
        }

        $userId = $user["user_id"];
        
        $method = $_SERVER['REQUEST_METHOD'];
        error_log("arrived here" . " " . $userId . " " . $method);

        switch ($method) {
            case 'GET':
                if (isset($_GET['id'])) {
                    return $this->taskModel->getTask($_GET['id'], $userId);
                } else {
                    return $this->taskModel->getAllTasks($userId);
                }
                break;

            case 'POST':
                $data = json_decode(file_get_contents('php://input'), true);
                if (isset($data['title'])) {
                    $this->taskModel->addTask($data['title'], $userId);
                    return ['message' => 'Task added'];
                }
                break;

            case 'PUT':
                $data = json_decode(file_get_contents('php://input'), true);
                if (isset($data['id'], $data['status'])) {
                    $this->taskModel->updateTask($data['id'], $data['status'], $userId);
                    return ['message' => 'Task updated'];
                }
                break;

            case 'DELETE':
                $data = json_decode(file_get_contents('php://input'), true);
                if (isset($data['id'])) {
                    $this->taskModel->deleteTask($data['id'], $userId);
                    return ['message' => 'Task deleted'];
                }
                break;

            default:
                http_response_code(405);
                return ['error' => 'Method Not Allowed'];
                break;
        }
    }

}
?>
