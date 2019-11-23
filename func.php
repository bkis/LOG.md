<?php

    function parsePostHeader($postHeader){
        $data = array();
        $lines = explode(PHP_EOL, $postHeader);
        foreach ($lines as $line){
            if (!strpos($line, ':')) continue;
            // separate prop key and value
            $data[trim(substr($line, 0, strpos($line, ':')))] 
                = trim(substr($line, strpos($line, ':') + 1));
        }
        // uppercase meta prop keys and return data
        return array_change_key_case($data, CASE_UPPER);
    }

?>