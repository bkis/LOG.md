<?php

define('LOGMD_POST_HEADER_DELIM', '++++');
define('LOGMD_THEME_NAME', 'default');

define('LOGMD_HTML_TITLE', 'LOG.md');
define('LOGMD_HEADER_TITLE', 'LOG.md');
define('LOGMD_HEADER_SUBTITLE', 'A flat-file markdown blogging sytem so primitive it barely works');

define('LOGMD_ROBOTS', 'noindex,nofollow');
define('LOGMD_SAFE_MODE', 1);

define('LOGMD_DEBUG_MODE', 1);

//    |  DON'T  |
//    |  TOUCH  |
//    V  THIS!  V

define('LOGMD_SEP', DIRECTORY_SEPARATOR);
define('LOGMD_THEME', 'themes' . LOGMD_SEP . LOGMD_THEME_NAME . LOGMD_SEP);
define('LOGMD_POSTS_DIR', 'posts' . LOGMD_SEP);

?>