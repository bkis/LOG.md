<?php

    // load config and functions
    require_once 'config.php';
    require_once 'func.php';

    // prep
    $posts;
    $post;
    $error = false;

    // check req
    if (isset($_GET['post'])){
        // get raw content of post file
        $post = readPost(htmlspecialchars($_GET['post']) . '.md');
        $error = !$post;
    } else {
        // get all files and directories in posts dir
        $postFiles = array_diff(scandir(LOGMD_POSTS_DIR), array('.', '..'));
        // filter out everything that doesn't end on '.md' or '.MD'
        $postFiles = array_values(preg_grep('/\.md$/i', $postFiles));
        // collect posts meta data
        $posts = array();
        foreach ($postFiles as $i => $postFile){
            // read post header
            $posts[$i] = readPostHeader($postFile);
        }
        // sort posts by publishing time string
        usort($posts, function($a, $b) {
            return strcmp($a[LOGMD_POSTS_SORT_BY], $b[LOGMD_POSTS_SORT_BY]);
        });
    }


    include 'header.php';
    //// include theme templates
    
    // theme header
    include LOGMD_THEME . '_header.php';

    // choose main content template
    if ($error){
        include LOGMD_THEME . '_404.php';
    } elseif (isset($post)){
        include LOGMD_THEME . '_post.php';
    } else {
        include LOGMD_THEME . '_posts.php';
    }
    
    // theme footer
    include LOGMD_THEME . '_footer.php';

    //common footer
    include 'footer.php';

    
?>
