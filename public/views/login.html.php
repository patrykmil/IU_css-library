<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Login page</title>
  <link rel="stylesheet" href="public/styles/default.css" />
  <link rel="stylesheet" href="public/styles/login.css" />
</head>

<body>
  <a href="../../index.html">
    <img class="logo" src="../../assets/images/logo.svg" alt="Logo" />
  </a>
  <div class="login_form_container">
    <form class="login_form" action="/login" method="POST">
      <div class="login_container">
        <label for="email_input">email address
            <input name="email_input" class="login_input" type="email" placeholder="email@email.iu" />
        </label>
      </div>
      <div class="login_container">
        <label for="password_input">password
            <input name="password_input" class="login_input" type="password" placeholder="password" />
        </label>
      </div>
      <button type='submit' class="login_button">SIGN IN</button>
    </form>
    <div class="login_other_options">
      <a href="#" class="login_option">Forgot Password?</a>
      <a href="register" class="login_option">Register</a>
    </div>
  </div>
</body>

</html>