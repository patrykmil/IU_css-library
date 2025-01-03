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
</head>

<body>
<?php include 'navigation.html.php'; ?>
<main>
    <div class="top_search">
        <div id="text">
            <p>Browse all elements</p>
        </div>
        <button class="filter_mobile_only">Filters</button>
        <div id="search">
            <img class="search_icon" src="/assets/icons/search_thick_grey.svg" alt="Search icon">
            <input class="search_bar" type="text" placeholder="Search using names or tags">
        </div>
    </div>
    <div class="bottom">
        <form class="filter">
            <div class="sort">
                <p>Sort by</p>
                <select id="sorting">
                    <option value="Most likes">Most likes</option>
                    <option value="Newest">Newest</option>
                    <option value="Oldest">Oldest</option>
                </select>
            </div>
            <div class="types">
                <p>Show</p>
                <div>
                    <button class="select">All</button>
                    <button class="select">None</button>
                </div>
                <div class="search_options">
                    <input type="checkbox">
                    <p>Buttons</p>
                </div>
                <div class="search_options">
                    <input type="checkbox">
                    <p>Inputs</p>
                </div>
                <div class="search_options">
                    <input type="checkbox">
                    <p>Checkboxes</p>
                </div>
                <div class="search_options">
                    <input type="checkbox">
                    <p>Radio buttons</p>
                </div>
            </div>
            <button class="filter_button">Apply</button>
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
                        <button class="copy no-redirect">
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