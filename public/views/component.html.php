<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Component page</title>
    <link rel="stylesheet" href="public/styles/default.css"/>
    <link rel="stylesheet" href="public/styles/component.css">
    <script src="public/scripts/mobile_menu.js" defer></script>
    <script src="public/scripts/code_area.js" defer></script>
</head>

<body>
<?php include 'navigation.html.php'; ?>
<div class="main">
    <div class="left_side">
        <div class="preview_container">
            <p>preview</p>
        </div>
        <?php include 'interaction_buttons.html.php'; ?>
        <div class="tags_container">
            <div class="tags">
                <button>
                    simple
                </button>
                <button>
                    self-made
                </button>
                <button>
                    colorless
                </button>
            </div>
        </div>
        <datalist id="tags">
            <option value="simple">
            <option value="self-made">
            <option value="colorless">
        </datalist>
    </div>
    <div class="right_side">
        <div class="code_container">
            <div>
                <button class="change_code" id="html_button" type="button">HTML</button>
                <button class="change_code active" id="css_button" type="button">CSS</button>
            </div>
            <textarea class="code auto_expand" id="html_textarea" name="html" readonly>html text</textarea>
            <textarea class="code active auto_expand" id="css_textarea" name="css" readonly>css text</textarea>
        </div>
    </div>
</div>
</body>

</html>