<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <link rel="stylesheet" href="/public/styles/default.css"/>
    <title>...</title>
</head>

<body>
<div class="second_layer">
    <img src="../assets/images/logo.svg" alt="Logo" width="50" height="50"/>
    <p>IU</p>
    <p>
        <?php
            if (isset($message)) {
                echo $message;
            }
        ?>
    </p>
</div>
</body>

</html>