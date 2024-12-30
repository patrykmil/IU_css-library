<?php
require_once __DIR__ . '/../../src/repositories/DefaultRepository.php';
if (!isset($userID)) {
    exit('No userid');
}
$repo = DefaultRepository::getInstance();
$types = $repo->getTypes();
$sets = $repo->getUserSets($userID);
$tags = $repo->getTagNames();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Component page</title>
    <link rel="stylesheet" href="/public/styles/default.css"/>
    <link rel="stylesheet" href="/public/styles/component.css">
    <script src="/public/scripts/code_area.js" defer></script>
</head>

<body>
<?php include 'navigation.html.php'; ?>
<form class="new_component_form" action="create_component" method="post">
    <div class="main">
        <div class="left_side">
            <div class="preview_container">
                <p>preview</p>
            </div>
            <div class="inputs_container">
                <input class="info_input" type="text" placeholder="Name" name="name">
                <input class="info_input" list="types" placeholder="Type" name="type">
                <input class="info_input" list="sets" placeholder="Set" name="set">
                <input class="info_input" type="text" placeholder="Color" name="color">
                <input class="info_input" list="tags" placeholder="Tags" name="tags">
                <div class="tags">
                    <!--                add js-->
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
                    <option value="+crete new">
                </datalist>
                <datalist id="tags">
                    <?php
                    foreach ($tags as $tag) {
                        echo '<option value="' . $tag . '">';
                    }
                    ?>
                </datalist>
            </div>
            <button class="submit_button" type="submit">Submit</button>
        </div>
        <div class="right_side">
            <p>Create new element</p>
            <div class="code_container">
                <div>
                    <button class="change_code" id="html_button" type="button">HTML</button>
                    <button class="change_code active" id="css_button" type="button">CSS</button>
                </div>
                <textarea class="code auto_expand" id="html_textarea" name="html" placeholder="Enter HTML"></textarea>
                <textarea class="code active auto_expand" id="css_textarea" name="css" placeholder="Enter CSS"></textarea>
            </div>
        </div>
    </div>
</form>
</body>

</html>