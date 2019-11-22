
<div class="site-frame">

    <h2>Look at these <?php echo sizeof($posts) ?> beautiful posts:</h2>

    <ul>
        <?php foreach ($posts as $post){ ?>
            <li>
                <a href="?post=<?php echo $post['LINK'] ?>"><?php echo $post['TITLE'] ?></a>
                <i>(<?php echo $post['TIME'] ?>)</i>
            </li>
        <?php } ?>
    </ul>

</div>