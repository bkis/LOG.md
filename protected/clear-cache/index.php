<?php

    //auth
    include '../auth.php';

    //// DELETE STATIC HTML CACHE

    // load config
    require_once '../../config.php';

    // array for rendered html cache files
    $postsRendered = array_values(
        preg_grep(
            '/\.html$/i',
            array_diff(
                scandir('../../' . LOGMD_RENDERED),
                array('.', '..')
            )
        )
    );

?>

    <h1>LOG.md</h1>
    <h2>Deleting <?php echo sizeof($postsRendered) ?> static HTML files of rendered posts ...</h2>

<?php
    $success = true;
    foreach ($postsRendered as $r) {
        $success = $success && unlink('../../' . LOGMD_RENDERED . $r);
    }
?>

    <strong><?php echo ($success ? "DONE!" : "There was some error...") ?></strong>