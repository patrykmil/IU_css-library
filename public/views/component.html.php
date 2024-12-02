<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Component page</title>
  <link rel="stylesheet" href="public/styles/default.css" />
  <link rel="stylesheet" href="public/styles/login.css" />
  <link rel="stylesheet" href="public/styles/navigation.css">
  <script src="../scripts/mobile_meu.js" defer></script>
</head>

<body>
  <h2><?= isset($login) ? $login : "" ?></h2>
  <h2>
      <?php if (isset($password)): ?>
            <h2><?= $password ?></h2>
      <?php endif; ?>
  </h2>
  <?php include 'navigation.html.php'; ?>
</body>

</html>