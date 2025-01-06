<!DOCTYPE html>
<html lang="en">

<?php if (!isset($components)) {
    $components = [];
} ?>

<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Browse components</title>
    <link rel="stylesheet" href="/public/styles/default.css"/>
    <link rel="stylesheet" href="/public/styles/browse.css"/>
    <script src="/public/scripts/stop_redirecting.js" defer></script>
    <script src="/public/scripts/select_filters.js" defer></script>
    <script src="/public/scripts/copy.js" defer></script>
</head>

<body>
<?php include 'navigation.html.php'; ?>
<main>
    <form id="filter_form" method="get" action="/browse">
        <div class="top_search">
            <div id="text">
                <p>Browse all elements</p>
            </div>
            <button class="filter_mobile_only" id="toggle_mobile_filters" type="button">Filters</button>
            <div id="search">
                <img class="search_icon" src="/assets/icons/search_thick_grey.svg" alt="Search icon">
                <input class="search_bar" type="text" name="search" placeholder="Search?">
            </div>
        </div>
        <div class="bottom">
            <div class="filter">
                <div class="sort">
                    <p>Sort by</p>
                    <select id="sorting" name="sorting">
                        <option value="Most likes">Most likes</option>
                        <option value="Newest">Newest</option>
                        <option value="Oldest">Oldest</option>
                    </select>
                </div>
                <div class="types">
                    <p>Show</p>
                    <div>
                        <button class="select" id="select_all" type="button">All</button>
                        <button class="select" id="deselect_all" type="button">None</button>
                    </div>
                    <label class="search_options">
                        <input type="checkbox" class="filter_checkbox" name="filters[]" value="Buttons">
                        <p>Buttons</p>
                    </label>
                    <label class="search_options">
                        <input type="checkbox" class="filter_checkbox" name="filters[]" value="Inputs">
                        <p>Inputs</p>
                    </label>
                    <label class="search_options">
                        <input type="checkbox" class="filter_checkbox" name="filters[]" value="Checkboxes">
                        <p>Checkboxes</p>
                    </label>
                    <label class="search_options">
                        <input type="checkbox" class="filter_checkbox" name="filters[]" value="Radio buttons">
                        <p>Radio buttons</p>
                    </label>
                </div>
                <button class="filter_button" type="submit">Apply</button>
            </div>
    </form>
    <div class="content">
        <?php foreach ($components as $component): ?>
            <a href="/component/<?php echo $component->getId(); ?>" class="browse_item">
                <div class="component no-redirect" id="component-<?php echo $component->getId(); ?>">
                    <style>
                        #component-<?php echo $component->getId(); ?> {
                        <?php echo htmlspecialchars_decode($component->getCss()); ?>
                        }
                    </style>
                    <?php echo htmlspecialchars_decode($component->getHtml()); ?>
                </div>
                <div class="description">
                    <?php
                    $color = '#' . $component->getColor();
                    echo '<p class="title" style="color:' . $color . ';">' . $component->getName() . '</p>';
                    echo '<p class="no-redirect">from <span style="color:' . $color . '; text-decoration: underline;">' . $component->getSet() . '</span> set</p>';
                    echo '<p class="no-redirect">by: ' . $component->getAuthor()->getNickname() . '</p>';
                    ?>
                </div>
                <div class="buttons">
                    <button class="like no-redirect">
                        <img src="/assets/icons/heart_nofill.svg" alt="Like icon">
                    </button>
                    <button class="copy no-redirect"
                            onclick="copy(encodeURIComponent('<?php echo htmlspecialchars(json_encode($component->getHtml()), ENT_QUOTES, 'UTF-8'); ?>'),
                                    encodeURIComponent('<?php echo htmlspecialchars(json_encode($component->getCss()), ENT_QUOTES, 'UTF-8'); ?>'))">
                        <img src="/assets/icons/copy.svg" alt="Copy icon">
                    </button>
                </div>
            </a>
        <?php endforeach; ?>
    </div>
    </div>
</main>
</body>

</html>