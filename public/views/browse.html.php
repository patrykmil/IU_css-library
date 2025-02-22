<!DOCTYPE html>
<html lang="en">

<?php if (!isset($components)) {
    $components = [];
} ?>

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Browse components</title>
    <link rel="stylesheet" href="/public/styles/default.css" />
    <link rel="stylesheet" href="/public/styles/browse.css" />
    <script src="/public/scripts/stop_redirecting.js" defer></script>
    <script src="/public/scripts/select_filters.js" defer></script>
    <script src="/public/scripts/copy.js" defer></script>
    <script src="/public/scripts/toggle_like.js" defer></script>
</head>

<body>
    <?php include 'navigation.html.php'; ?>
    <main>
        <form id="filter-form" method="get" action="/browse">
            <div class="top-search">
                <div id="text">
                    <p>Browse all elements</p>
                </div>
                <button class="filter_mobile" id="toggleMobileFilters" type="button">Filters</button>
                <div id="search">
                    <img class="search-icon" src="/assets/icons/search_thick_grey.svg" alt="Search icon">
                    <input class="search-bar" type="text" name="search" placeholder="Search?">
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
                            <button class="select" id="selectAll" type="button">All</button>
                            <button class="select" id="deselectAll" type="button">None</button>
                        </div>
                        <label class="search_options">
                            <input type="checkbox" class="filter-checkbox" name="filters[]" value="Buttons">
                            <p>Buttons</p>
                        </label>
                        <label class="search_options">
                            <input type="checkbox" class="filter-checkbox" name="filters[]" value="Inputs">
                            <p>Inputs</p>
                        </label>
                        <label class="search_options">
                            <input type="checkbox" class="filter-checkbox" name="filters[]" value="Checkboxes">
                            <p>Checkboxes</p>
                        </label>
                        <label class="search_options">
                            <input type="checkbox" class="filter-checkbox" name="filters[]" value="Radio buttons">
                            <p>Radio buttons</p>
                        </label>
                    </div>
                    <button class="filter-button" type="submit">Apply</button>
                </div>
        </form>
        <div class="component-preview">
            <?php foreach ($components as $component): ?>
                <?php include 'component_preview.html.php'; ?>
            <?php endforeach; ?>
        </div>
    </main>
</body>

</html>