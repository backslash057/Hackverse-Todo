<?php

require_once $_SERVER["DOCUMENT_ROOT"] . "/controllers/authController.php";

$controller = new AuthController();
$userData = $controller->checkAuthentification();

if (!$userData) {
    require_once $_SERVER["DOCUMENT_ROOT"] . "/views/landing_page.php";
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Todo List App</title>
  <style><?php include_once $_SERVER["DOCUMENT_ROOT"] . "/public/css/dashboard.css" ?></style>
  <style><?php include_once $_SERVER["DOCUMENT_ROOT"] . "/public/css/fonts.css" ?></style>
</head>
<body>
  <nav class="menu">
    <img src="/public/imgs/logo.png" alt="Logo" class="logo">
    <div class="profile-menu">
      <img src="/public/imgs/profile.jpg" alt="Profile" class="profile-icon">
      <?php echo($userData["names"] . " " . $userData["surnames"]); ?>
      <img class="dropdown-icon" src="/public/imgs/dropdown.png" alt="Dropdown button icon">
      <div class="dropdown">
        <a href="/logout" class="logout-btn">
            <img src="/public/imgs/logout.png" class="icon"> Logout
        </a>
      </div>
    </div>
  </nav>

  <h1><span class="heading">TODO</span> List</h1>

  <div class="input-div">
    <input type="text" class="input" placeholder="Add a task...">
    <button class="add-button">Add</button>
  </div>

  <div class="container"></div>

  <div id="toast-container"></div>

  <script src="/public/js/dashboard.js"></script>
</body>
</html>
