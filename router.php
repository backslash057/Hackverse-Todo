<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/controllers/authController.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/controllers/taskController.php';


$requestUri = rtrim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), "/");
if($requestUri == "") $requestUri = "/";

$method = $_SERVER['REQUEST_METHOD'];

error_log($method . " " . $requestUri);

// no matter what is the request method
if($requestUri == "/") { 
    require_once($_SERVER["DOCUMENT_ROOT"] . "/views/landing_page.php");
}
else if($requestUri == "/dashboard") {
    require_once($_SERVER["DOCUMENT_ROOT"] . "/views/dashboard.php");
}
else if ($requestUri == '/login') {
    if($method == 'POST') {
        // TODO: add a try catch in case operation fails
        $controller = new AuthController();
        $response = $controller->login();

        header("Content-Type: application/json");
        echo json_encode($response);
    }
    else if($method == "GET") {
        require_once($_SERVER["DOCUMENT_ROOT"] . "/views/auth/login.php");
    }
}
else if ($requestUri == '/signup') {
    if($method == 'POST') {
        // TODO: add a try catch in case operation fails
        $controller = new AuthController();
        $response = $controller->signup();

        header("Content-Type: application/json");
        echo json_encode($response);
    }
    else if($method == "GET") {
        require_once $_SERVER['DOCUMENT_ROOT'] . "/views/auth/signup.php";
    }
}
else if($requestUri == "/logout") {
    if($method == "POST") {
        // TODO: add a try catch in case operation fails
        $controller = new AuthController();
        $response = $controller->logout();
        
        header("Content-Type: application/json");
        echo json_encode($response);
    }
    else if($method == "GET"){
        require_once $_SERVER["DOCUMENT_ROOT"] . "/views/auth/logout.php";
    }
}
else if($requestUri == "/api/todo") {
    $controller = new TaskController();
    $response = $controller->handleRequest($method);

    header("Content-Type: application/json");
    echo json_encode($response);
}
else if (str_starts_with($requestUri, '/public/')) {
    $path = $_SERVER["DOCUMENT_ROOT"] . $requestUri;
    if (file_exists($path)) {
        $mime = mime_content_type($path);
        header("Content-Type: $mime");
        readfile($path);
        exit;
    }
}
else {
    require_once $_SERVER["DOCUMENT_ROOT"] . "/views/404.html";
}

?>
