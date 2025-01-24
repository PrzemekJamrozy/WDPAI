<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DateSpark</title>
    <link rel="stylesheet" href="views/styles/main.css"/>
    <link rel="stylesheet" href="views/styles/navbar.css"/>
    <link rel="stylesheet" href="views/styles/toast.css"/>

</head>
<body>
<?php include "./views/common/navbar.php"; ?>
<?php include "./views/common/toast.php"?>
<div class="main-container">
    <!-- Karta osoby -->
    <div class="profile-card">
        <img src="/uploads/placeholder.png" alt="Zdjęcie osoby" class="user-image">
    </div>

    <!-- Informacje o osobie -->
    <div class="info">
        <p class="username"></p>
        <p class="bio"></p>
    </div>

    <!-- Przyciski akcji -->
    <div class="action-buttons">
        <button class="action-button reject-button" >
            <img src="https://img.icons8.com/ios-filled/50/ffffff/delete-sign.png" alt="Odrzuć">
        </button>
        <button class="action-button accept-button" >
            <img src="https://img.icons8.com/ios-filled/50/ffffff/like.png" alt="Zainteresowany">
        </button>
    </div>

    <script src="/views/scripts/Navbar.js"></script>
    <script type="module" src="/views/scripts/Swiper.js"></script>
</div>
</body>
</html>
