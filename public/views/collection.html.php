<?php
if (!isset($liked)) {
    $liked = [];
}
if (!isset($owned)) {
    $owned = [];
}
if (!isset($user)) {
    $user = null;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Collection</title>
    <link rel="stylesheet" href="/public/styles/default.css"/>
    <link rel="stylesheet" href="/public/styles/browse.css"/>
    <link rel="stylesheet" href="/public/styles/collection.css"/>
    <script src="/public/scripts/stop_redirecting.js" defer></script>
    <script src="/public/scripts/copy.js" defer></script>
    <script src="/public/scripts/toggle_like.js" defer></script>
    <script src="/public/scripts/collection.js" defer></script>
    <script src="/public/scripts/deleteFromCollection.js" type="module" defer></script>
</head>

<body>
<?php include 'navigation.html.php'; ?>
<main>
    <div class="chosen">
        <div class="btn-group">
            <button class="btn left active" type="button" id="owned">Self made</button>
            <button class="btn right" type="button" id="liked">Liked</button>
        </div>
    </div>
    <div class="component-preview">
        <div class="components liked">
            <div class="group-container">
                <?php foreach ($liked as $component): ?>
                    <?php include 'component_preview.html.php'; ?>
                <?php endforeach; ?>
            </div>
        </div>
        <div class="components owned active">
            <?php foreach ($owned as $set):
                if (empty($set['components'])) {
                    continue;
                }
                ?>
                <div class="list">
                    <p class="title"><?php echo $set['name']; ?></p>
                    <div class="group-container">
                        <?php foreach ($set['components'] as $component): ?>
                            <?php include 'component_preview.html.php'; ?>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</main>
</body>

</html>