
<div class="pagination">
    <?php
        if ($posts['PAGES'] > 1){
            for ($i=1; $i <= $posts['PAGES']; $i++) { 
                if ($i === $posts['PAGE']){
    ?>
        <span class="pagination-number"><?php echo $i ?></span>
    <?php       } else { ?>
        <span class="pagination-number">
            <a href="?p=<?php echo $i ?>"><?php echo $i ?></a>
        </span>
    <?php       
                }
            }
        }
    ?>
</div>