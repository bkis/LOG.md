<?php

    function fixMarkdownLinks($md){
        // replace links to other markdown files with working LOG.md post links (ugly)
        return preg_replace('/([^(]+)\.md(?=\))/i', '?post=$1#content', $md);
    }

    function fixMarkdownImagePaths($md){
        // fix image paths (also ugly)
        return preg_replace('/(!\[[^\]]+\]\()([^()]+)(?=\))/i', '$1' . LOGMD_POSTS_DIR_PATH . '$2', $md);
    }

    function readPostContent($postData){
        //check if rendered version of post exists
        $renderedPath = LOGMD_RENDERED . $postData['FILE'] . '.html';
        if (file_exists($renderedPath)){
            $postData['POST'] = file_get_contents($renderedPath);
        } else {
            //// post not rendered, yet. render now...
            // load parsedown
            require_once 'lib/Parsedown.php';
            
            // process links and paths in post md content
            $postData['POST'] = fixMarkdownLinks($postData['POST']);
            $postData['POST'] = fixMarkdownImagePaths($postData['POST']);
            
            // parse with Parsedown
            $Parsedown = new Parsedown();
            $Parsedown->setUrlsLinked(false);
            
            if (LOGMD_SAFE_MODE){
                $Parsedown->setSafeMode(true);
                $Parsedown->setMarkupEscaped(true);
            }
            $postData['POST'] = $Parsedown->text($postData['POST']);

            //...and save rendered HTML for next time
            file_put_contents($renderedPath, $postData['POST']);
        }
        return $postData['POST'];
    }


    function readPostData($rawPostContent, $postFileName){
        // extract post meta header
        $headerContent = substr($rawPostContent, 0, 
            strpos($rawPostContent, LOGMD_POST_HEADER_DELIM));
        // no header content found
        if (!$headerContent) return false;
        
        //// parse header
        $data = array();
        // split into lines
        $lines = explode(PHP_EOL, $headerContent);
        foreach ($lines as $line){
            if (!strpos($line, ':')) continue;
            // separate prop key and value
            $data[trim(substr($line, 0, strpos($line, ':')))] 
                = trim(substr($line, strpos($line, ':') + 1));
        }

        // save post link id
        $data['LINK'] = preg_replace('/\.md$/i', '', $postFileName);
        $data['FILE'] = $postFileName;
        
        // uppercase meta prop keys
        $data = array_change_key_case($data, CASE_UPPER);
        
        // if TIME is missing, try to get last modification time of md file
        if (!isset($data['TIME'])){
            $data['TIME'] = date("Y-m-d H:i", filemtime(LOGMD_POSTS_DIR_PATH . $postFileName));
        }

        // extract actual post md content
        $data['POST'] = substr($rawPostContent,
            strpos($rawPostContent, LOGMD_POST_HEADER_DELIM) + strlen(LOGMD_POST_HEADER_DELIM));
        
        //return post data
        return $data;
    }


    function readPostFile($postFileName){
        if (!file_exists(LOGMD_POSTS_DIR_PATH . $postFileName)) return false;
        return file_get_contents(LOGMD_POSTS_DIR_PATH . $postFileName);
    }


    function readPost($postFileName, $offset = 0){
        $rawPostContent = readPostFile($postFileName);
        if (!$rawPostContent) return false;
        $post = readPostData($rawPostContent, $postFileName);
        // get/parse content
        $post['POST'] = readPostContent($post);
        return $post;
    }


    function getPostsFiles(){
        return array_values(
            preg_grep(
                '/\.md$/i',
                array_diff(
                    scandir(LOGMD_POSTS_DIR_PATH),
                    array('.', '..')
                )
            )
        );
    }


    function readPosts($page = 1){
        // get all posts files' paths
        $posts = getPostsFiles();

        // read each post's data without parsing/reading html
        foreach ($posts as $i => $postFileName){
            $posts[$i] = readPostData(readPostFile($postFileName), $postFileName);
        }

        // sort posts by primary and secondary sort features
        // ATTENTION: This also re-calculates the numeric keys of the array,
        // which is intentional, here! They don't have to be calculated again!
        usort($posts, function($a, $b) {
            $compOne = strcmp($a[LOGMD_POSTS_SORT_BY_1], $b[LOGMD_POSTS_SORT_BY_1]);
            $compOne *= LOGMD_POSTS_SORT_BY_1_ASC ? 1 : -1;
            if (!$compOne){
                $compOne = strcmp($a[LOGMD_POSTS_SORT_BY_2], $b[LOGMD_POSTS_SORT_BY_2]);
                $compOne *= LOGMD_POSTS_SORT_BY_2_ASC ? 1 : -1;
            }
            return $compOne;
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

        // Get / render html content of each post to show
        foreach ($posts as $post){
            $post['POST'] = readPostContent($post);
        }

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