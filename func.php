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
        // uppercase meta prop keys and return data
        return array_change_key_case($data, CASE_UPPER);
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

?>