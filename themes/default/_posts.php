
<div class="markdown-body">

    <h2>There are <?php echo sizeof($posts) ?> posts:</h2>

    <ul>
        <?php foreach ($posts as $post){ ?>
            <li>
                <a href="../?post=<?php echo $post['LINK'] ?>"><?php echo $post['TITLE'] ?></a>
                <i>(<?php echo $post['TIME'] ?>)</i>
            </li>
        <?php } ?>
    </ul>

</div>