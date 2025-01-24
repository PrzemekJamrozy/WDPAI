<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DateSpark</title>
    <link rel="stylesheet" href="views/styles/common.css">
    <link rel="stylesheet" href="views/styles/user-profile.css">
    <link rel="stylesheet" href="views/styles/navbar.css">
</head>
<body>
<?php include "./views/common/navbar.php"?>
<div class="container" id="user-profile">
    <h1>Profil Użytkownika</h1>
    <div class="user-card">
        <img class="user__profile-avatar" src="#" alt="Avatar">
        <div>
            <p class="user__profile-name"><strong>Imię:</strong> </p>
            <p class="user__profile-surname"><strong>Nazwisko:</strong> </p>
            <p class="user__profile-email"><strong>Email:</strong> </p>
            <p class="user__profile-sex"><strong>Płeć:</strong> </p>
            <a href="/edit-profile" class="button">Edytuj Profil</a>
            <a href="/delete-account" class="button">Usuń Konto</a>
        </div>
    </div>
</div>

<script type="module" src="/views/scripts/Navbar.js"></script>
<script type="module" src="/views/scripts/UserProfile.js"></script>
</body>
</html>
