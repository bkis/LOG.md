<?php

    // load config and functions
    require_once 'config.php';
    require_once 'func.php';

    // debug mode?
    if (LOGMD_DEBUG_MODE){
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
    }

    // prep
    $posts;
    $post;
    $error = false;

    // check req
    if (isset($_GET['post'])){
        // load parsedown
        require_once 'lib/Parsedown.php';
        // (potential) post file name
        $postFileName = htmlspecialchars($_GET['post']) . '.md';
        // get raw content of post file
        $post = file_get_contents(LOGMD_POSTS_DIR . $postFileName);
        // parse post content
        if ($post){
            // parse raw post file content
            $post = parsePost($post, $postFileName);
        } else {
            // some error (this should really be more detailed)
            $error = true;
        }
    } else {
        // get all files and directories in posts dir
        $postFiles = array_diff(scandir(LOGMD_POSTS_DIR), array('.', '..'));
        // filter out everything that doesn't end on '.md' or '.MD'
        $postFiles = array_values(preg_grep('/\.md$/i', $postFiles));
        // collect posts meta data
        $posts = array();
        foreach ($postFiles as $i => $postFile){
            // get post content
            $posts[$i] = file_get_contents(LOGMD_POSTS_DIR . $postFile);
            // parse post meta header
            $posts[$i] = parsePostHeader($posts[$i], $postFile);
        }
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
