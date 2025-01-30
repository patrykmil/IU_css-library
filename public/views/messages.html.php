<?php
if (!isset($deleted)) {
    $deleted = [];
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Collection</title>
    <link rel="stylesheet" href="/public/styles/default.css"/>
    <link rel="stylesheet" href="/public/styles/messages.css"/>
    <script src="/public/scripts/copy.js" defer></script>
</head>

<body>
<?php include 'navigation.html.php'; ?>
<main>
    <?php foreach ($deleted as $component): ?>
        <div class="deleted-message">
            <div class="description">
                <p class="name">Component: <span class="colored"> <?php echo $component->getName(); ?> </span> has been deleted by moderator</p>
                <p class="description">Reason: <?php echo $component->getMessage()->getDescription(); ?></p>
            </div>
            <button class="copy-button"
                    onclick="copy(encodeURIComponent('<?php echo htmlspecialchars(json_encode($component->getHtml()), ENT_QUOTES, 'UTF-8'); ?>'),
                            encodeURIComponent('<?php echo htmlspecialchars(json_encode($component->getCss()), ENT_QUOTES, 'UTF-8'); ?>'))">
                <img src="/assets/icons/copy.svg" alt="Copy Icon"/>
            </button>
        </div>
    <?php endforeach; ?>
</main>
</body>

</html>