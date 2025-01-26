<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Login page</title>
    <link rel="stylesheet" href="/public/styles/default.css"/>
    <link rel="stylesheet" href="/public/styles/login.css"/>
    <script src="/public/scripts/validate_register.js" defer></script>
</head>

<body>
<a href="/start">
    <img class="logo" src="../../assets/images/logo.svg" alt="Logo"/>
</a>
<div class="login-form-container">
    <form class="login-form" action="/register" method="POST">
        <div class="login-container">
            <label for="email-input">email address
                <input name="email-input" class="login-input" type="email" placeholder="email@email.iu"/>
            </label>
        </div>
        <div class="login-container">
            <label for="nickname-input">nickname
                <input name="nickname-input" class="login-input" type="text" placeholder="IuNick"/>
            </label>
        </div>
        <div class="login-container">
            <label for="password-input">password
                <input name="password-input" class="login-input" type="password" placeholder="password"/>
            </label>
        </div>
        <button type='submit' class="login-button">REGISTER</button>
    </form>
    <div class="login-other-options">
        <a href="/login" class="login-option">Log in</a>
    </div>
</div>
<?php if (isset($message) && $message !== "Successfully registered!!!") : ?>
    <div class="validity-message">
        <p><?= $message ?></p>
    </div>
<?php endif; ?>
</body>

</html>