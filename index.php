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
        //get page number
        $page;
        if (!isset($_GET['p']) 
            || ($page = intval(htmlspecialchars($_GET['p']))) <= 0){
            $page = 1;
        }
        // get all posts' meta data
        $posts = readPosts($page);
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
