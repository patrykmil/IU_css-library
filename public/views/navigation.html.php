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
                <a href="#" class="menu_item"><img src="../../assets/icons/search_thick.svg" alt="Browse Icon"/> BROWSE</a>
            </li>
            <li>
                <a href="#" class="menu_item"><img src="../../assets/icons/bookmark_fill.svg" alt="Collection Icon"/>
                    COLLECTION</a>
            </li>
            <li>
                <a href="#" class="menu_item"><img src="../../assets/icons/create.svg" alt="Create Icon"/> CREATE</a>
            </li>
            <?php if (isset($_COOKIE['user_session'])): ?>
                <li class="mobile_only_option">
                    <a href="#" class="menu_item">PROFILE</a>
                </li>
                <li class="mobile_only_option">
                    <a href="#" class="menu_item">LOG OUT</a>
                </li>
            <?php else: ?>
                <li class="mobile_only_option">
                    <a href="#" class="menu_item">LOG IN</a>
                </li>
            <?php endif; ?>
        </ul>

        <a href="#" class="mobile_menu_icon menu_item menu_show"><img src="../../assets/icons/menu.svg"
                                                                      alt="Menu Icon"/></a>
    </div>

    <div class="top_nav_right">
        <?php if (isset($_COOKIE['user_session'])): ?>
            <img class="right_menu_item" src="../../assets/avatars/hair_green.svg" alt="My Avatar"/>
            <div class="right_menu_text">LOG OUT</div>
        <?php else: ?>
            <div class="right_menu_text">LOG IN</div>
        <?php endif; ?>
    </div>
</nav>
</body>

</html>