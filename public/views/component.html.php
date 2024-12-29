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
    <script src="/public/scripts/mobile_menu.js" defer></script>
    <script src="/public/scripts/code_area.js" defer></script>
    <link rel="stylesheet" href="/public/prism/prism.css">
    <script src="/public/prism/prism.js" defer></script>
    <style>
        .component_preview {
        <?php echo htmlspecialchars_decode($component->getCss()); ?>
        }
    </style>
</head>

<body>
<?php include 'navigation.html.php'; ?>
<div class="main">
    <div class="left_side">
        <div class="preview_container">
            <p>preview</p>
            <div class="component_preview">
                <?php echo htmlspecialchars_decode($component->getHtml()); ?>
            </div>
        </div>
        <?php include 'interaction_buttons.html.php'; ?>
        <div class="tags_container">
            <div class="tags">
                <?php foreach ($component->getTags() as $tag): ?>
                    <button style="background-color: #<?php echo $tag->getColor(); ?>;"><?php echo $tag->getName(); ?></button>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
    <div class="right_side">
        <div class="code_container">
            <div>
                <button class="change_code" id="html_button" type="button">HTML</button>
                <button class="change_code active" id="css_button" type="button">CSS</button>
            </div>
            <pre class="code auto_expand" id="html_textarea">
                <code class="language-html match-braces">
                    <?php echo $component->getHtml(); ?>
                </code>
            </pre>
            <pre class="code active auto_expand" id="css_textarea">
                <code class="language-css match-braces">
                    <?php echo $component->getCss(); ?>
                </code>
            </pre>
        </div>
    </div>
</div>
</body>

</html>