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

    function readPost($postFileName, $offset = 0){
        $content = file_get_contents(LOGMD_POSTS_DIR . $postFileName);
        return !$content ? false : parsePost(
            $content,
            $postFileName
        );
    }

    function getPostsFiles(){
        return array_values(
            preg_grep(
                '/\.md$/i',
                array_diff(
                    scandir(LOGMD_POSTS_DIR),
                    array('.', '..')
                )
            )
        );
    }

    function getPostsData($page = 1){
        // get all posts files' paths
        $posts = getPostsFiles();

        // read each post's header
        foreach ($posts as $i => $postFile){
            $posts[$i] = readPostHeader($postFile);
        }

        // sort posts by primary and secondary sort features
        // ATTENTION: This also re-calculates the numeric keys of the array,
        // which is intentional, here! They don't have to be calculated again!
        usort($posts, function($a, $b) {
            $compOne = strcmp($a[LOGMD_POSTS_SORT_BY_1], $b[LOGMD_POSTS_SORT_BY_1]);
            return $compOne !== 0 ? $compOne : strcmp($a[LOGMD_POSTS_SORT_BY_2], $b[LOGMD_POSTS_SORT_BY_2]);
        });

        // PAGINATION: calculate values
        $size = LOGMD_POSTS_PER_PAGE; // results size
        $total = sizeof($posts); // total posts count
        $pages = intval($total / $size) + ($total % $size == 0 ? 0 : 1); // no. of pages
        if ($total <= $size || $page > $pages) $page = 1; // set page to 1
        $from = ($page - 1) * LOGMD_POSTS_PER_PAGE; // index of first post to return
        $range = range($from, $from + LOGMD_POSTS_PER_PAGE - 1); // indexes range to return
        
        // PAGINATION: filter for posts of requested page
        $posts = array_filter(
            $posts,
            function ($key) use ($range) {
                return in_array($key, $range);
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