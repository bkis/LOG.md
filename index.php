<?php

    // load config
    require_once 'config.php';

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
        // get raw content of post file
        $post = file_get_contents(LOGMD_POSTS_DIR . LOGMD_SEP . htmlspecialchars($_GET['post']) . '.md');
        if ($post){
            // reduce to actual content (exclude meta header)
            $post = substr($post, strpos($post, LOGMD_POST_HEADER_DELIM) + strlen(LOGMD_POST_HEADER_DELIM));
            // replace links to other markdown files with working LOG.md post links
            $post = preg_replace('/(?=\()([^(\/]+)\.md(?=\)\[)/i', '../?post=$1', $post);
            // pare with Parsedown
            $Parsedown = new Parsedown();
            if (LOGMD_SAFE_MODE){
                $Parsedown->setSafeMode(true);
                $Parsedown->setMarkupEscaped(true);
            }
            $post = $Parsedown->text($post);
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
            $postText = file_get_contents(LOGMD_POSTS_DIR . LOGMD_SEP . $postFile);
            // parse post meta header
            $posts[$i] = parse_ini_string(
                substr($postText, 0, strpos($postText, LOGMD_POST_HEADER_DELIM))
            );
            // save post file name
            $posts[$i]['LINK'] = substr($postFile, 0, strlen($postFile) - 3);
            // uppercase meta prop names
            $posts[$i] = array_change_key_case($posts[$i], CASE_UPPER); 
        }
    }


    include 'header.php';
    //// include theme templates
    
    // theme header
    include LOGMD_THEME . '_header.php';

    // choose main content template
    if ($error){
        include LOGMD_THEME . '_404.php';
    } elseif (isset($post) && strlen($post) > 0){
        include LOGMD_THEME . '_post.php';
    } else {
        include LOGMD_THEME . '_posts.php';
    }
    
    // theme footer
    include LOGMD_THEME . '_footer.php';

    //common footer
    include 'footer.php';

    
?>
