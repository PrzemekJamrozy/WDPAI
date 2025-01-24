<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DateSpark</title>
    <link rel="stylesheet" href="views/styles/common.css">
    <link rel="stylesheet" href="views/styles/user-profile.css">
    <link rel="stylesheet" href="views/styles/edit-profile.css">
    <link rel="stylesheet" href="views/styles/navbar.css">
</head>
<body>
<?php include './views/common/navbar.php'?>
<div class="container" id="edit-profile">
    <h1>Edytuj Profil</h1>
    <form action="/save-profile" method="POST" enctype="multipart/form-data">
        <label>Link do Facebooka: <input type="url" name="fbLink"></label><br>
        <label>Link do Instagrama: <input type="url" name="igLink"></label><br>
        <label>Bio: <textarea name="bio"></textarea></label><br>
        <label>Preferowana płeć:
            <select name="preferredSex">
                <option value="MALE">Mężczyzna</option>
                <option value="FEMALE">Kobieta</option>
            </select>
        </label><br>
        <label>Email: <input type="email" name="email"></label><br>
        <label>Hasło: <input type="password" name="password"></label><br>
        <label>Avatar: <input type="file" name="avatar"></label><br>
        <button type="submit" class="button">Zapisz</button>
    </form>
</div>

<script src="/views/scripts/Navbar.js"></script>
<script src="/views/scripts/EditProfile.js"></script>
</body>
</html>
