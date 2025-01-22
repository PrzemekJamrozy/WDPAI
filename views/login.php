<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form</title>
    <link rel="stylesheet" href="/views/styles/common.css">
    <link rel="stylesheet" href="/views/styles/common-onboarding.css">
    <link rel="stylesheet" href="/views/styles/toast.css">
</head>
<body>
<?php include "./views/common/toast.php"?>
<div class="container">
    <h1>Logowanie</h1>
    <form class="login-form">
        <div class="form-group">
            <label for="email">Email użytkownika</label>
            <input type="text" id="email" name="email" placeholder="Podaj email" required>
        </div>
        <div class="form-group">
            <label for="password">Hasło</label>
            <input type="password" id="password" name="password" placeholder="Podaj hasło" required>
        </div>
        <button type="submit" class="login-btn btn-submit">Zaloguj się</button>
    </form>
    <p>Nie masz konta? <a href="/register">Zarejestruj się</a></p>
    <script type="module" src="/views/scripts/Login.js"></script>
</div>
</body>
</html>
