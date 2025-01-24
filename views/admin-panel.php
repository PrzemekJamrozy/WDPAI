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
<?php include './views/common/navbar.php'?>
<div class="container" id="admin-panel">
    <h1>Panel Administratora</h1>
    <div class="user-card">
        <img src="avatar-placeholder.jpg" alt="Avatar">
        <div>
            <p><strong>Imię:</strong> Anna</p>
            <p><strong>Nazwisko:</strong> Nowak</p>
            <a href="/edit-user/1" class="button">Edytuj</a>
            <a href="/delete-user/1" class="button">Usuń</a>
        </div>
    </div>
</div>
<script src="/views/scripts/Navbar.js"></script>
</body>
</html>
