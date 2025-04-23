<?php

require_once $_SERVER["DOCUMENT_ROOT"] . "/controllers/authController.php";

// Try, load and verify the user data from cookies
$controller = new Authcontroller();
$userData = $controller->checkAuthentification();

if ($userData) {
    header("Location: /logout");
    exit;
}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription - Todo</title>
    <style><?php include_once $_SERVER["DOCUMENT_ROOT"] . "/public/css/auth.css"; ?></style>
    <style><?php include_once $_SERVER["DOCUMENT_ROOT"] . "/public/css/fonts.css"; ?></style>
</head>
<body>

    <div class="container">
        <div class="logo">
            <img src="imgs/logo.png" alt="Website logo">
        </div>

        <div class="error_frame">An error occured</div>

        <form action="/signup" class="form signup-form">
            <div class="form-entry">
                <label class="form-label required" for="fnames">First names</label>
                <input class="form-input" type="text" name="fnames" id="fnames" required>
            </div>
            <div class="form-entry">
                <label class="form-label" for="lnames">Last names</label>
                <input class="form-input" type="text" name="lnames" id="lnames">
            </div>
            <div class="form-entry">
                <label class="form-label required" for="email">Email address</label>
                <input class="form-input" type="email" name="email" id="email" required>
            </div>
            <div class="form-entry">
                <label class="form-label required" for="phone">Phone number</label>
                <input class="form-input" type="text" name="phone" id="phone" required>
            </div>
            <div class="form-entry">
                <label class="form-label required" for="birth_date">Birth date</label>
                <input class="form-input" type="date" name="birth_date" id="birth_date" required>
            </div>
            <div class="form-entry">
                <label class="form-label" for="gender">Gender</label>
                <select name="gender" id="gender">
                    <option value="M">Male</option>
                    <option value="F">Female</option>
                </select>
            </div>
            <div class="form-entry full-width">
                <label class="form-label required" for="password">Password</label>
                <input class="form-input" type="password" name="password" id="password" required>
            </div>
            <input type="submit" value="Sign up" class="full-width">
            <div class="form-footer full-width">
                <span>Already have an account?</span>
                <a href="/login">Log in</a>
            </div>
        </form>
    </div>

    <script src="js/auth.js"></script>
</body>
</html>
