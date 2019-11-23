
<div class="site-frame">

    <h2>Would you like some sample content with this?</h2>
    The little monkey is tired from reading these <?php echo $posts['TOTAL'] ?> very, very boring posts:

    <ul>
        <?php foreach ($posts['POSTS'] as $post){ ?>
            <li>
                <a href="?post=<?php echo $post['LINK'] ?>"><?php echo $post['TITLE'] ?></a>
                <i>(published <?php echo $post['TIME'] ?>)</i>
            </li>
        <?php } ?>
    </ul>

    <!-- pagination -->
    <?php include 'blocks/pagination.php' ?>
    
</div>