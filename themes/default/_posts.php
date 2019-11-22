
<h2>These are the posts: <?php echo sizeof($posts) ?></h2>

<ul>
    <?php foreach ($posts as $post){ ?>
        <li>
            <a href="../?post=<?php echo $post['LINK'] ?>"><?php echo $post['TITLE'] ?></a>
            <i>(<?php echo $post['TIME'] ?>)</i>
        </li>
    <?php } ?>
</ul>