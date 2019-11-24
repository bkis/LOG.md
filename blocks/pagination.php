
<div class="pagination">

    <?php if ($posts['PAGES'] > 1){ ?>
        
        <!-- PREVIOUS -->
        <a href="?p=<?php echo ($posts['PAGE'] == 1 ? $posts['PAGES'] : $posts['PAGE'] - 1) ?>"><span class="pagination-link pagination-previous"><?php echo LOGMD_PAGINATION_PREV ?></span></a>

        <?php for ($i=1; $i <= $posts['PAGES']; $i++) { 
                if ($i === $posts['PAGE']){ ?>
        
        <!-- CURRENT PAGE -->
        <span class="pagination-link pagination-current"><?php echo $i ?></span>

    <?php } else { ?>

        <!-- OTHER PAGES -->
        <a href="?p=<?php echo $i ?>"><span class="pagination-link pagination-other"><?php echo $i ?></span></a>

    <?php } } ?>

        <!-- NEXT -->
        <a href="?p=<?php echo ($posts['PAGE'] == $posts['PAGES'] ? 1 : $posts['PAGE'] + 1) ?>"><span class="pagination-link pagination-next"><?php echo LOGMD_PAGINATION_NEXT ?></span></a>

    <?php } ?>
</div>