<?php

if (!isset($userID) || !isset($types) || !isset($sets) || !isset($tags)) {
    require_once __DIR__ . '/../../src/controllers/ErrorController.php';
    ErrorController::getInstance()->error500();
    return;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Create component page</title>
    <link rel="stylesheet" href="/public/styles/default.css"/>
    <link rel="stylesheet" href="/public/styles/component.css">
    <link rel="stylesheet" href="/public/styles/create.css">
    <script src="/public/scripts/change_code.js" defer></script>
    <script src="/public/scripts/code_area.js" defer></script>
    <script src="/public/scripts/choose_tags.js" defer></script>
    <script src="/public/scripts/inputs_validation.js" defer></script>
    <script src="/public/scripts/add_new_component.js" defer></script>
    <script src="/public/scripts/add_set.js" defer></script>
    <script src="/public/scripts/update_preview.js" defer></script>
    <style>
        .component-preview * {
            all: revert;
        }
    </style>
</head>

<body>
<?php include 'navigation.html.php'; ?>
<div class="main">
    <div class="left_side">
        <?php include 'preview_container.html.php'; ?>
        <form class="new-component-form" action="/create" method="post">
            <div class="inputs-container">
                <input class="info-input" type="text" placeholder="Name" name="name">
                <input class="info-input" list="types" placeholder="Type" name="type">
                <input class="info-input" list="sets" placeholder="Set" name="set">
                <input class="info-input" type="text" placeholder="Color HEX" name="color">
                <input class="info-input" list="tags" placeholder="Tags" id="tags_input">
                <div class="tags">
                </div>
                <datalist id="types">
                    <?php
                    foreach ($types as $type) {
                        echo '<option value="' . $type . '">';
                    }
                    ?>
                </datalist>
                <datalist id="sets">
                    <?php
                    foreach ($sets as $set) {
                        echo '<option value="' . $set . '">';
                    }
                    ?>
                    <option value="+create new">
                </datalist>
                <datalist id="tags">
                    <?php
                    foreach ($tags as $tag) {
                        echo '<option value="' . $tag . '">';
                    }
                    ?>
                </datalist>
            </div>
            <button class="submit-button" type="submit">Submit</button>
        </form>
    </div>
    <div class="right-side">
        <p>Create new element</p>
        <div class="code-container">
            <div>
                <button class="change-code" id="htmlButton" type="button">HTML</button>
                <button class="change-code active" id="cssButton" type="button">CSS</button>
            </div>
            <textarea class="code auto-expand" id="htmlTextarea" name="html" placeholder="Enter HTML"></textarea>
            <textarea class="code active auto-expand" id="cssTextarea" name="css"
                      placeholder="Enter CSS"></textarea>
        </div>
    </div>
</div>
<div id="popup" class="popup">
    <div class="popup-content">
        <span class="close">&times;</span>
        <h2>Create New Set</h2>
        <input type="text" id="newSetName" placeholder="Enter new set name">
        <button id="createSetButton">Create</button>
    </div>
</div>
</body>

</html>