<?php

    define('LOGMD_ENTRIES_DIR', 'entries');
    define('LOGMD_ENTRY_HEADER_DELIM', '++++');
    define('LOGMD_THEME_NAME', 'default');

    define('LOGMD_HTML_TITLE', 'LOG.md');
    define('LOGMD_PAGE_TITLE', 'LOG.md');
    define('LOGMD_PAGE_SUBTITLE', 'A flat-file markdown blogging sytem so primitive it barely works');

    define('LOGMD_ROBOTS', 'noindex,nofollow');
    define('LOGMD_SAFE_MODE', 1);

    define('LOGMD_DEBUG_MODE', 1);

    //    |  DON'T  |
    //    |  TOUCH  |
    //    V  THIS!  V

    define('LOGMD_SEP', DIRECTORY_SEPARATOR);
    define('LOGMD_THEME', 'themes' . LOGMD_SEP . LOGMD_THEME_NAME . LOGMD_SEP);

?>