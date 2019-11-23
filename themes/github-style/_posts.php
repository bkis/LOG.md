
<div class="site-frame">

    <h2>Look at these <?php echo $posts['TOTAL'] ?> beautiful posts:</h2>

    <ul>
        <?php foreach ($posts['POSTS'] as $post){ ?>
            <li>
                <a href="?post=<?php echo $post['LINK'] ?>"><?php echo $post['TITLE'] ?></a>
                <i>(<?php echo $post['TIME'] ?>)</i>
            </li>
        <?php } ?>
    </ul>

    <!-- pagination -->
    <?php include 'blocks/pagination.php' ?>

</div>