<?php
if (!isset($component)) {
    require_once 'src/controllers/ErrorController.php';
    ErrorController::getInstance()->error404();
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="/public/styles/interaction_buttons.css">
</head>

<body>
<div class="interaction_buttons_container">
    <button class="interaction_button"
            onclick="copy(encodeURIComponent('<?php echo htmlspecialchars(json_encode($component->getHtml()), ENT_QUOTES, 'UTF-8'); ?>'),
                    encodeURIComponent('<?php echo htmlspecialchars(json_encode($component->getCss()), ENT_QUOTES, 'UTF-8'); ?>'))">
        <img src="/assets/icons/copy.svg" alt="Copy Icon"/>
    </button>
    <form class="like_button_form" action="like" method="post">
        <button class="interaction_button" type="submit">
            <img src="/assets/icons/heart_nofill.svg" alt="Like Icon"/>
        </button>
    </form>
    <form class="bookmark_button_form" action="bookmark" method="post">
        <button class="interaction_button" type="submit">
            <img src="/assets/icons/bookmark_fill_purple.svg" alt="Bookmark Icon"/>
        </button>
    </form>
</div>
</body>
</html>