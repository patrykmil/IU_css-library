<?php
require_once __DIR__ . '/../../src/utilities/Decoder.php';

$avatarUrl = null;
$cookieData = Decoder::decodeUserSession();
if ($cookieData) {
    $avatarUrl = $cookieData->getAvatar() ?? null;
    $nickname = $cookieData->getNickname() ?? null;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="/public/styles/navigation.css">
    <script src="/public/scripts/mobile_menu.js" defer></script>
</head>

<body>
<nav>
    <div class="top-nav-left">
        <a href="/start">
            <img class="logo" src="../../assets/images/logo.svg" alt="Logo"/>
        </a>
        <ul class="nav-options-list">
            <li>
                <form action="/browse" method="get">
                    <button type="submit" class="menu-item">
                        <img src="../../assets/icons/search_thick.svg" alt="Browse Icon"/>BROWSE
                    </button>
                </form>
            </li>
            <li>
                <form action="<?php echo isset($nickname) ? '/collection/' . $nickname : '/login'; ?>" method="get">
                    <button type="submit" class="menu-item">
                        <img src="../../assets/icons/bookmark_fill.svg" alt="Collection Icon"/>COLLECTION
                    </button>
                </form>
            </li>
            <li>
                <form action="/create" method="get">
                    <button type="submit" class="menu-item">
                        <img src="../../assets/icons/create.svg" alt="Create Icon"/>CREATE
                    </button>
                </form>
            </li>
            <?php if (isset($_COOKIE['user_session'])): ?>
                <li class="mobile-option">
                    <a class="menu-item">PROFILE</a>
                </li>
                <li class="mobile-option">
                    <form action="/logout" method="post">
                        <button type="submit" class="menu-item">LOG OUT</button>
                    </form>
                </li>
            <?php else: ?>
                <li class="mobile-option">
                    <form action="/login" method="get">
                        <button type="submit" class="menu-item">LOG IN</button>
                    </form>
                </li>
            <?php endif; ?>
        </ul>

        <a class="mobile-menu-icon menu-item menu-show"><img src="../../assets/icons/menu.svg"
                                                             alt="Menu Icon"/></a>
    </div>

    <div class="top_nav_right">
        <?php if (isset($_COOKIE['user_session'])): ?>
            <a href="/messages">
                <img class="right_menu-item"
                     src="../../assets/avatars/<?php echo $avatarUrl; ?>"
                     alt="My Avatar"/>
                <form action="/logout" method="post">
                    <button type="submit" class="right-menu-text">LOG OUT</button>
                </form>
            </a>
        <?php else: ?>
            <form action="/login" method="get">
                <button type="submit" class="right-menu-text">LOG IN</button>
            </form>
        <?php endif; ?>
    </div>
</nav>
</body>

</html>