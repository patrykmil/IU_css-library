<?php
$code = $code ?? 404;
$message = $message ?? "Page not found";
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?php echo $code?></title>
    <link rel="stylesheet" href="/public/styles/default.css" />
    <link rel="stylesheet" href="/public/styles/error.css" />
  </head>

  <body>
    <img src="../../assets/images/logo.svg" alt="logo" />
    <h1><?php echo $code?></h1>
    <h2><?php echo $message?></h2>
  </body>
</html>
