<!DOCTYPE html>
<html lang="en">

<head>
    <script src="/public/scripts/switch_background.js" defer></script>
</head>

<body>
<div class="preview-container">
    <p>preview</p>
    <div class="background_switch">
        <label class="switch btn-color-mode-switch">
            <input value="1" id="color_mode" name="color_mode" type="checkbox" checked>
            <label class="btn-color-mode-switch-inner" data-off="Light" data-on="Dark" for="color_mode"></label>
        </label>
    </div>
    <div class="component-preview">
        <?php if (isset($component)) : ?>
            <?php echo htmlspecialchars_decode($component->getHtml()); ?>
        <?php endif; ?>
    </div>
</div>
</body>

</html>