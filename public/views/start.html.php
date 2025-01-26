<?php if (!isset($user)) {
    $user = null;
} ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <link rel="stylesheet" href="/public/styles/default.css"/>
    <link rel="stylesheet" href="/public/styles/start.css"/>
    <script src="/public/scripts/game.js" defer></script>
    <title>Get started!</title>
</head>

<body>
<main>
    <div class="navigation">
        <?php if ($user === null) : ?>
        <div class="container logo">
            <img src="/assets/images/logo.svg" alt="Logo"/>
        </div>
        <?php else: ?>
        <div class="container user">
            <img src="/assets/avatars/<?php echo $user->getAvatar()?>" alt="User"/>
            <p><?php echo $user->getNickname()?></p>
            <a href="/logout" class="logout">Log out</a>
        </div>
        <?php endif; ?>
        <a href="/browse" class="browse">
            <div class="container hover">
                <img src="/assets/icons/search_thick.svg" alt="Browse"/>
                <p>Browse</p>
            </div>
        </a>
        <?php if ($user !== null) : ?>
            <a href="/collection/<?= $user->getNickname() ?>" class="collection">
                <div class="container hover">
                    <img src="/assets/icons/bookmark_fill.svg" alt="Collection"/>
                    <p>Collection</p>
                </div>
            </a>
            <a href="/create" class="create">
                <div class="container hover">
                    <img src="/assets/icons/create.svg" alt="Create"/>
                    <p>Create</p>
                </div>
            </a>
        <?php else: ?>
            <div class="container login hover">
                <a href="/login">
                    <p class="purple_text">Login</p>
                </a>
            </div>
            <div class="container register hover">
                <a href="/register">
                    <p class="purple_text">Register</p>
                </a>
            </div>
        <?php endif; ?>
    </div>
    <div class="container game">
        <div class="game-ui">
            <p class="game-string">Memory game</span></p>
            <button class="start game-button">Start</button>
        </div>
        <div class="tiles">
            <button class="tile game-button" data-value="1">1</button>
            <button class="tile game-button" data-value="2">2</button>
            <button class="tile game-button" data-value="3">3</button>
            <button class="tile game-button" data-value="4">4</button>
            <button class="tile game-button" data-value="5">5</button>
            <button class="tile game-button" data-value="6">6</button>
        </div>
    </div>
</main>
</body>

</html>