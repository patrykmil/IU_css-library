<?php /** @var Component $component */ ?>
<?php if (!isset($user)) {$user = null;} ?>

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
        <?php if ($component->isLiked() !== null): ?>
            <?php $likeIcon = $component->isLiked() ? 'heart_fill.svg' : 'heart_nofill.svg'; ?>
            <button class="like" data-component-id="<?php echo $component->getId(); ?>">
                <img src="/assets/icons/<?php echo $likeIcon; ?>" alt="Like icon">
            </button>
        <?php endif; ?>
        <button class="copy no-redirect"
                onclick="copy(encodeURIComponent('<?php echo htmlspecialchars(json_encode($component->getHtml()), ENT_QUOTES, 'UTF-8'); ?>'),
                        encodeURIComponent('<?php echo htmlspecialchars(json_encode($component->getCss()), ENT_QUOTES, 'UTF-8'); ?>'))">
            <img src="/assets/icons/copy.svg" alt="Copy icon">
        </button>
        <?php if ($user !== null && $component->getAuthor()->getId() === $user->getId() && $component->isLiked() === null): ?>
            <button class="delete no-redirect" data-component-id="<?php echo $component->getId(); ?>">
                <img src="/assets/icons/delete.svg" alt="Like icon">
            </button>
        <?php endif; ?>
    </div>
</a>