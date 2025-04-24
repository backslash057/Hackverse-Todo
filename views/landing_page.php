<?php

require_once $_SERVER["DOCUMENT_ROOT"] . "/controllers/authController.php";

$controller = new AuthController();
$userData = $controller->checkAuthentification();

if ($userData) {
    require_once $_SERVER["DOCUMENT_ROOT"] . "/views/dashboard.php";
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Todo | Home</title>

    <style><?php include_once $_SERVER["DOCUMENT_ROOT"] . "/public/css/fonts.css"; ?></style>
    <style><?php include_once $_SERVER["DOCUMENT_ROOT"] . "/public/css/landing_page.css"; ?></style>
</head>
<body>
    <nav class="menu">
        <a href="/" class="logo">
            <img src="/public/imgs/logo.png" alt="Website logo">
        </a>
        <div class="menu-links">
            <a href="/login" class="link login">Log In</a>
            <a href="/signup" class="link signup">Sign Up</a> 
        </div>
    </nav>

    <div class="container">
        <img class="landing-image" src="/public/imgs/home_design.png" alt="Illustration of school management app">
        
        <h1 class="main-text">All your tasks in one place</h1>
        <h4 class="secondary-text">
            Manage your work, track your progress, and stay connected with your teams in one place.
        </h4>

        <div class="action-buttons">
            <a href="/signup" class="btn primary">Create my account</a>
            <a href="/signup" class="btn secondary">Get Started</a>
        </div>
    </div>
</body>
</html>
