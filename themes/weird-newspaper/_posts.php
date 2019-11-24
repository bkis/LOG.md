
<div class="site-frame">

    <h2>We have these <?php echo $posts['TOTAL'] ?> brilliant articles for you to read:</h2>

    <ul>
        <?php foreach ($posts['POSTS'] as $post){ ?>
            <li>
                <a href="?post=<?php echo $post['LINK'] ?>"><?php echo $post['TITLE'] ?></a>
                <i> &ctdot; <?php echo $post['TIME'] ?></i>
            </li>
        <?php } ?>
    </ul>

    <!-- pagination -->
    <?php include 'blocks/pagination.php' ?>

</div>