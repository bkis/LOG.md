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
    $entries;
    $entry;
    $error = false;

    // check req
    if (isset($_GET['entry'])){
        // load parsedown
        require_once 'lib/Parsedown.php';
        // get raw content of entry file
        $entry = file_get_contents(LOGMD_ENTRIES_DIR . LOGMD_SEP . htmlspecialchars($_GET['entry']) . '.md');
        if ($entry){
            // reduce to actual content (exclude meta header)
            $entry = substr($entry, strpos($entry, LOGMD_ENTRY_HEADER_DELIM) + strlen(LOGMD_ENTRY_HEADER_DELIM));
            // replace links to other markdown files with working LOG.md entry links
            $entry = preg_replace('/([^(]+)\.md(?=\))/i', '../?entry=$1', $entry);
            // pare with Parsedown
            $Parsedown = new Parsedown();
            if (LOGMD_SAFE_MODE){
                $Parsedown->setSafeMode(true);
                $Parsedown->setMarkupEscaped(true);
            }
            $entry = $Parsedown->text($entry);
        } else {
            $error = true;
        }
    } else {
        // get all files and directories in entries dir
        $entryFiles = array_diff(scandir(LOGMD_ENTRIES_DIR), array('.', '..'));
        // filter out everything that doesn't end on '.md' or '.MD'
        $entryFiles = array_values(preg_grep('/\.md$/i', $entryFiles));
        // collect entries meta data
        $entries = array();
        foreach ($entryFiles as $i => $entryFile){
            // get entry content
            $entryText = file_get_contents(LOGMD_ENTRIES_DIR . LOGMD_SEP . $entryFile);
            // parse entry meta header
            $entries[$i] = parse_ini_string(
                substr($entryText, 0, strpos($entryText, LOGMD_ENTRY_HEADER_DELIM))
            );
            // save entry file name
            $entries[$i]['LINK'] = substr($entryFile, 0, strlen($entryFile) - 3);
            // uppercase meta prop names
            $entries[$i] = array_change_key_case($entries[$i], CASE_UPPER); 
        }
    }


    include 'header.php';
    //// include theme templates
    
    // theme header
    include LOGMD_THEME . '_header.php';

    // choose main content template
    if ($error){
        include LOGMD_THEME . '_404.php';
    } elseif (isset($entry) && strlen($entry) > 0){
        include LOGMD_THEME . '_entry.php';
    } else {
        include LOGMD_THEME . '_entries.php';
    }
    
    // theme footer
    include LOGMD_THEME . '_footer.php';

    //common footer
    include 'footer.php';

    
?>
