<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DateSpark</title>
    <link rel="stylesheet" href="/views/styles/common.css"/>
    <link rel="stylesheet" href="/views/styles/common-onboarding.css">
    <link rel="stylesheet" href="/views/styles/toast.css">
</head>
<body>
<?php include "./views/common/toast.php"?>
<div class="container">
    <h1>Rejestracja</h1>
    <form class="register-form">
        <div class="form-group">
            <label for="name">Imię</label>
            <input type="text" id="name" name="name" placeholder="Wpisz swoje imię" required>
        </div>
        <div class="form-group">
            <label for="surname">Nazwisko</label>
            <input type="text" id="surname" name="surname" placeholder="Wpisz swoje nazwisko" required>
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" placeholder="Wpisz swój email" required>
        </div>
        <div class="form-group">
            <label for="password">Hasło</label>
            <input type="password" id="password" name="password" placeholder="Wpisz hasło" required>
        </div>
        <div class="form-group">
            <label for="password-again">Powtórz hasło</label>
            <input type="password" id="password-again" name="passwordAgain" placeholder="Powtórz hasło" required>
        </div>
        <div class="form-group">
            <label for="sex">Płeć</label>
            <select id="sex" name="sex" required>
                <option value="MALE">Mężczyzna</option>
                <option value="FEMALE">Kobieta</option>
            </select>
        </div>
        <button type="submit" class="register-btn btn-submit">Zarejestruj się</button>
    </form>
    <p>Masz już konto? <a href="/login">Zaloguj się</a></p>

    <script type="module" src="/views/scripts/Register.js"></script>
</div>
</body>
</html>