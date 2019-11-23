<?php

    function fixMarkdownLinks($md){
        // replace links to other markdown files with working LOG.md post links (ugly)
        return preg_replace('/([^(]+)\.md(?=\))/i', '?post=$1#content', $md);
    }

    function fixMarkdownImagePaths($md){
        // fix image paths (also ugly)
        return preg_replace('/(!\[[^\]]+\]\()([^()]+)(?=\))/i', '$1' . LOGMD_POSTS_DIR . '$2', $md);
    }

    function parsePostHeader($rawPostContent, $postFileName){
        $data = array();
        // reduce to post meta header
        $rawPostContent = substr($rawPostContent, 0, 
            strpos($rawPostContent, LOGMD_POST_HEADER_DELIM));
        // split into lines
        $lines = explode(PHP_EOL, $rawPostContent);
        foreach ($lines as $line){
            if (!strpos($line, ':')) continue;
            // separate prop key and value
            $data[trim(substr($line, 0, strpos($line, ':')))] 
                = trim(substr($line, strpos($line, ':') + 1));
        }
        // save post link id
        $data['LINK'] = preg_replace('/\.md$/i', '', $postFileName);
        // uppercase meta prop keys
        $data = array_change_key_case($data, CASE_UPPER);
        // if TIME is missing, try to get last modification time of md file
        if (!isset($data['TIME'])){
            $data['TIME'] = date("Y-m-d H:i", filemtime(LOGMD_POSTS_DIR . $postFileName));
        }
        //return post meta data
        return $data;
    }

    function parsePost($rawPostContent, $postFileName){
        // load parsedown
        require_once 'lib/Parsedown.php';
        // parse header
        $data = parsePostHeader($rawPostContent, $postFileName);
        // add actual post md content
        $data['POST'] = substr(
            $rawPostContent,
            strpos(
                $rawPostContent,
                LOGMD_POST_HEADER_DELIM
            ) + strlen(LOGMD_POST_HEADER_DELIM)
        );
        // process links and paths in post md content
        $data['POST'] = fixMarkdownLinks($data['POST']);
        $data['POST'] = fixMarkdownImagePaths($data['POST']);
        // parse with Parsedown
        $Parsedown = new Parsedown();
        if (LOGMD_SAFE_MODE){
            $Parsedown->setSafeMode(true);
            $Parsedown->setMarkupEscaped(true);
        }
        $data['POST'] = $Parsedown->text($data['POST']);
        return $data;
    }

    function readPostHeader($postFileName){
        $content = file_get_contents(LOGMD_POSTS_DIR . $postFileName);
        return !$content ? false : parsePostHeader(
            $content,
            $postFileName
        );
    }

    function readPost($postFileName){
        $content = file_get_contents(LOGMD_POSTS_DIR . $postFileName);
        return !$content ? false : parsePost(
            $content,
            $postFileName
        );
    }

    function getPostsData($page = 1){
        // get all files and directories in posts dir
        $posts = array_diff(scandir(LOGMD_POSTS_DIR), array('.', '..'));
        // filter out everything that doesn't end on '.md' or '.MD'
        $posts = preg_grep('/\.md$/i', $posts);
        foreach ($posts as $i => $postFile){
            // read post header
            $posts[$i] = readPostHeader($postFile);
        }
        // sort posts by publishing time string
        usort($posts, function($a, $b) {
            $compOne = strcmp($a[LOGMD_POSTS_SORT_BY_1], $b[LOGMD_POSTS_SORT_BY_1]);
            return $compOne !== 0 ? $compOne : strcmp($a[LOGMD_POSTS_SORT_BY_2], $b[LOGMD_POSTS_SORT_BY_2]);
        });
        // re-calc numeric keys
        $posts = array_values($posts);

        //// PAGINATION
        $size = LOGMD_POSTS_PER_PAGE; // results size
        $total = sizeof($posts); // total posts count
        $pages = intval($total / $size) + ($total % $size == 0 ? 0 : 1); // no. of pages
        if ($total <= $size || $page > $pages) $page = 1; // set page to 1
        $from = ($page - 1) * LOGMD_POSTS_PER_PAGE; // index of first post to return
        $range = range($from, $from + LOGMD_POSTS_PER_PAGE - 1); // indexes range to return
        // filter for requested posts
        $posts = array_filter(
            $posts,
            function ($i) use ($range) {
                return in_array($i, $range);
            },
            ARRAY_FILTER_USE_KEY
        );

        // put it all together
        return [
            'POSTS' => $posts,
            'TOTAL' => $total,
            'SIZE' => $size,
            'PAGE' => $page,
            'PAGES' => $pages
        ];
    }

?>