
<div class="site-frame">

    <h2>Would you like some sample content with this?</h2>
    The little monkey is tired from reading these <?php echo sizeof($posts) ?> very, very boring posts:

    <ul>
        <?php foreach ($posts as $post){ ?>
            <li>
                <a href="?post=<?php echo $post['LINK'] ?>"><?php echo $post['TITLE'] ?></a>
                <i>(published <?php echo $post['TIME'] ?>)</i>
            </li>
        <?php } ?>
    </ul>

</div>