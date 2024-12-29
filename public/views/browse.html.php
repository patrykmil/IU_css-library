<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Browse components</title>
    <link rel="stylesheet" href="/public/styles/default.css"/>
    <link rel="stylesheet" href="/public/styles/browse.css"/>
</head>

<body>
<?php include 'navigation.html.php'; ?>
<main>
    <div class="top_search">
        <div id="text">
            <p>Browse all elements</p>
        </div>
        <div id="search">
            <img class="search_icon" src="/assets/icons/search_thick_grey.svg" alt="Search icon">
            <input class="search_bar" type="text" placeholder="Search using names or tags">
        </div>
    </div>
    <div class="bottom">
        <div class="filter">
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
        <div class="content">
            content
        </div>
    </div>
</main>
</body>

</html>