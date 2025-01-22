<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Form</title>
    <link rel="stylesheet" href="/views/styles/common.css"/>
    <link rel="stylesheet" href="/views/styles/common-onboarding.css">
    <link rel="stylesheet" href="/views/styles/onboarding.css">
    <link rel="stylesheet" href="/views/styles/toast.css">
</head>
<body>
<?php include "./views/common/toast.php" ?>
<div class="container">
    <form class="onboarding-form">
        <?php include "./views/onboarding/onboarding-step-one.php" ?>
        <?php include "./views/onboarding/onboarding-step-two.php" ?>
        <?php include "./views/onboarding/onboarding-step-three.php" ?>
        <?php include "./views/onboarding/onboarding-step-four.php" ?>

        <div class="onboarding-btn-group">
            <button type="button" class="onboarding-back-btn btn-back removed">Wróć</button>
            <button type="button" class="onboarding-next-btn btn-submit">Następny krok</button>
            <button type="submit" class="onboarding-finish-btn btn-submit removed">Zakończ</button>
        </div>

    </form>

    <script type="module" src="/views/scripts/Onboarding.js"></script>
</div>
</body>
</html>