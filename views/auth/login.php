<?php

require_once $_SERVER["DOCUMENT_ROOT"] . "/controllers/authController.php";


// Try, load and verify the user datas from his cookies
$controller = new Authcontroller();
$userData = $controller->checkAuthentification();

if($userData) {
    header("Location: /logout");
    exit;
}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - Todo</title>
    <style><?php include_once $_SERVER["DOCUMENT_ROOT"] . "/public/css/auth.css" ?></style>
    <style><?php include_once $_SERVER["DOCUMENT_ROOT"] . "/public/css/fonts.css" ?></style>
</head>
<body>
    <div class="container login-container">
        <div class="logo">
            <img src="imgs/logo.png" alt="Website logo">
        </div>

        <div class="error_frame">An Error occured</div> 

        <form action="/login" class="form">
            <div class="form-entry">
                <label class="form-label required" for="email">Email address</label>
                <input class="form-input" type="email" name="email" id="email" required>
            </div>
            <div class="form-entry">
                <label class="form-label required" for="password">Password</label>
                <input class="form-input" type="password" name="password" id="password" required>
            </div>
            <input type="submit" value="Log in">
            <div class="form-footer full-width">
                <span>No account yet?</span>
                <a href="/signup">Sign up</a>
            </div>
        </form>

    </div>
    <!-- <script src="/static/js/debug.js"></script> -->
    <script src="js/auth.js"></script>
</body>
</html>
