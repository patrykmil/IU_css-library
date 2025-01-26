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
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Component page</title>
    <link rel="stylesheet" href="/public/styles/default.css"/>
    <link rel="stylesheet" href="/public/styles/component.css">
    <script src="/public/scripts/change_code.js" defer></script>
    <script src="/public/scripts/copy.js" defer></script>
    <link rel="stylesheet" href="/public/prism/prism.css">
    <script src="/public/prism/prism.js" defer></script>
    <link rel="stylesheet" href="/public/styles/interaction_buttons.css">
    <script src="/public/scripts/toggle_like.js" defer></script>
    <script src="/public/scripts/deleteFromComponentPage.js" type="module" defer></script>
    <script src="/public/scripts/copyLink.js" type="module" defer></script>
    <style>
        .component-preview * {
            all: revert;
        }

        .component-preview {
        <?php echo htmlspecialchars_decode($component->getCss()); ?>
        }
    </style>
</head>

<body>
<?php include 'navigation.html.php'; ?>
<div class="main">
    <div class="left_side">
        <?php include 'preview_container.html.php'; ?>
        <div class="interaction-buttons-container">
            <button class="interaction-button"
                    onclick="copy(encodeURIComponent('<?php echo htmlspecialchars(json_encode($component->getHtml()), ENT_QUOTES, 'UTF-8'); ?>'),
                            encodeURIComponent('<?php echo htmlspecialchars(json_encode($component->getCss()), ENT_QUOTES, 'UTF-8'); ?>'))">
                <img src="/assets/icons/copy.svg" alt="Copy Icon"/>
            </button>
            <?php if ($component->isLiked() !== null): ?>
                <?php $likeIcon = $component->isLiked() ? 'heart_fill.svg' : 'heart_nofill.svg'; ?>
                <button class="interaction-button like" data-component-id="<?php echo $component->getId(); ?>">
                    <img src="/assets/icons/<?php echo $likeIcon; ?>" alt="Like icon">
                </button>
            <?php endif; ?>
            <button class="interaction-button share">
                <img src="/assets/icons/share.svg" alt="Share Icon"/>
            </button>
            <?php if (isset($user) and $user->getId() === $component->getAuthor()->getID()): ?>
                <button class="interaction-button delete" data-component-id="<?php echo $component->getId(); ?>">
                    <img src="/assets/icons/delete.svg" alt="Delete Icon"/>
                </button>
            <?php endif; ?>
        </div>
        <div class="tags-container">
            <div class="tags">
                <?php foreach ($component->getTags() as $tag): ?>
                    <button style="background-color: #<?php echo $tag->getColor(); ?>;"><?php echo $tag->getName(); ?></button>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
    <div class="right-side">
        <div class="code-container">
            <div>
                <button class="change-code" id="htmlButton" type="button">HTML</button>
                <button class="change-code active" id="cssButton" type="button">CSS</button>
            </div>
            <pre class="code auto-expand" id="htmlTextarea">
                <code class="language-html match-braces">
                    <?php echo $component->getHtml(); ?>
                </code>
            </pre>
            <pre class="code active auto-expand" id="cssTextarea">
                <code class="language-css match-braces">
                    <?php echo $component->getCss(); ?>
                </code>
            </pre>
        </div>
    </div>
</div>
</body>

</html>