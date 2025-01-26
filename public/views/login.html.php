<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Login page</title>
    <link rel="stylesheet" href="/public/styles/default.css"/>
    <link rel="stylesheet" href="/public/styles/login.css"/>
</head>

<body>
<a href="/start">
    <img class="logo" src="../../assets/images/logo.svg" alt="Logo"/>
</a>
<div class="login-form-container">
    <form class="login-form" action="/login" method="POST">
        <div class="login-container">
            <label for="email-input">email address
                <input name="email-input" class="login-input" type="email" placeholder="email@email.iu"/>
            </label>
        </div>
        <div class="login-container">
            <label for="password-input">password
                <input name="password-input" class="login-input" type="password" placeholder="password"/>
            </label>
        </div>
        <button type='submit' class="login-button">SIGN IN</button>
    </form>
    <div class="login-other-options">
        <a href="/register" class="login-option">Register</a>
    </div>
</div>
<?php if (isset($message) && $message !== "Successfully registered!!!") : ?>
    <div class="validity-message">
        <p><?= $message ?></p>
    </div>
<?php endif; ?>
<?php if (isset($message) && $message === "Successfully registered!!!") : ?>
    <div class="registered-message">
        <p><?= $message ?></p>
    </div>
<?php endif; ?>
</body>

</html>