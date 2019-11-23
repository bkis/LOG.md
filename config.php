<?php

    define('LOGMD_POST_HEADER_DELIM', '++++');
    define('LOGMD_THEME_NAME', 'sleeping-monkey'); // default themes: 'sleeping-monkey' and 'github-style'

    define('LOGMD_HTML_TITLE', 'LOG.md');
    define('LOGMD_HEADER_TITLE', 'This is LOG.md');
    define('LOGMD_HEADER_SUBTITLE', 'A flat-file markdown blogging sytem so primitive it\'s a miracle it even works');
    define('LOGMD_FOOTER_LINK', 1);
    define('LOGMD_POSTS_SORT_BY', 'TIME'); // can be 'TIME', 'TITLE' or whatever you are using in your posts headers, but it HAS TO BE UPPERCASED, here!

    define('LOGMD_ROBOTS', 'noindex,nofollow');
    define('LOGMD_SAFE_MODE', 1);

    define('LOGMD_DEBUG_MODE', 1);



    //    |  DON'T  |
    //    |  TOUCH  |
    //    V  THIS!  V

    // internal config
    define('LOGMD_SEP', DIRECTORY_SEPARATOR);
    define('LOGMD_THEME', 'themes' . LOGMD_SEP . LOGMD_THEME_NAME . LOGMD_SEP);
    define('LOGMD_POSTS_DIR', 'posts' . LOGMD_SEP);

    // debug mode?
    ini_set('display_errors', LOGMD_DEBUG_MODE ? 1 : 0);
    ini_set('display_startup_errors', LOGMD_DEBUG_MODE ? 1 : 0);
    error_reporting( LOGMD_DEBUG_MODE ? E_ALL : 0);

?>