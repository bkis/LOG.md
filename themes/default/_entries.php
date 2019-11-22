
<h2>These are the entries: <?php echo sizeof($entries) ?></h2>

<ul>
    <?php foreach ($entries as $entry){ ?>
        <li>
            <a href="../?entry=<?php echo $entry['LINK'] ?>"><?php echo $entry['TITLE'] ?></a>
            <i>(<?php echo $entry['TIME'] ?>)</i>
        </li>
    <?php } ?>
</ul>