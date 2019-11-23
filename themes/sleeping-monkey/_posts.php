
<div class="site-frame">

    <h2>The monkey is tired from reading these <?php echo sizeof($posts) ?> boring posts:</h2>

    <ul>
        <?php foreach ($posts as $post){ ?>
            <li>
                <a href="?post=<?php echo $post['LINK'] ?>"><?php echo $post['TITLE'] ?></a>
                <i>(published <?php echo $post['TIME'] ?>)</i>
            </li>
        <?php } ?>
    </ul>

</div>