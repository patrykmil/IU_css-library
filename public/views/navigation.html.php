<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="public/styles/navigation.css">
</head>

<body>
<nav>
    <div class="top_nav_left">
        <img class="logo" src="../../assets/images/logo.svg" alt="Logo"/>
        <ul class="nav_options_list">
            <li>
                <form action="/browse" method="get">
                    <button type="submit" class="menu_item">
                        <img src="../../assets/icons/search_thick.svg" alt="Browse Icon"/>BROWSE
                    </button>
                </form>
            </li>
            <li>
                <form action="/collection" method="get">
                    <button type="submit" class="menu_item">
                        <img src="../../assets/icons/bookmark_fill.svg" alt="Collection Icon"/>COLLECTION
                    </button>
                </form>
            </li>
            <li>
                <form action="/create" method="get">
                    <button type="submit" class="menu_item">
                        <img src="../../assets/icons/create.svg" alt="Create Icon"/>CREATE
                    </button>
                </form>
            </li>
            <?php if (isset($_COOKIE['user_session'])): ?>
                <li class="mobile_only_option">
                    <a class="menu_item">PROFILE</a>
                </li>
                <li class="mobile_only_option">
                    <form action="/logout" method="post">
                        <button type="submit" class="menu_item">LOG OUT</button>
                    </form>
                </li>
            <?php else: ?>
                <li class="mobile_only_option">
                    <form action="/login" method="get">
                        <button type="submit" class="menu_item">LOG IN</button>
                    </form>
                </li>
            <?php endif; ?>
        </ul>

        <a class="mobile_menu_icon menu_item menu_show"><img src="../../assets/icons/menu.svg"
                                                             alt="Menu Icon"/></a>
    </div>

    <div class="top_nav_right">
        <?php if (isset($_COOKIE['user_session'])): ?>
            <img class="right_menu_item" src="../../assets/avatars/hair_green.svg" alt="My Avatar"/>
            <form action="/logout" method="post">
                <button type="submit" class="right_menu_text">LOG OUT</button>
            </form>
        <?php else: ?>
            <form action="/login" method="get">
                <button type="submit" class="right_menu_text">LOG IN</button>
            </form>
        <?php endif; ?>
    </div>
</nav>
</body>

</html>