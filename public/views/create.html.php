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
</head>

<body>
<?php include 'navigation.html.php'; ?>
<form class="new_component_form" action="create_component" method="post">
    <div class="main">
        <div class="left_side">
            <div class="preview_container">
                <p>preview</p>
            </div>
            <div class="tags_container">
                <input class="info_input" list="tags" placeholder="Add tags" name="tags">
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
            <div class="inputs_container">
                <input class="info_input" list="sets" placeholder="Select set" name="set">
                <datalist id="sets">
                    <option value="set1">
                    <option value="set2">
                    <option value="set3">
                </datalist>
                <input class="info_input" type="text" placeholder="Name" name="name">
                <input class="info_input" type="text" placeholder="Type" name="type">
                <input class="info_input" type="text" placeholder="Color" name="color">
            </div>
            <p>Create new element</p>
        </div>
        <div class="right_side">
            <button class="submit_button" type="submit">Submit</button>
            <div class="code_container">
                <div>
                    <button class="change_code" id="html_button" type="button">HTML</button>
                    <button class="change_code active" id="css_button" type="button">CSS</button>
                </div>
                <textarea class="code auto_expand" id="html_textarea" name="html">html text</textarea>
                <textarea class="code active auto_expand" id="css_textarea" name="css">css text</textarea>
            </div>
        </div>
    </div>
</form>
</body>

</html>