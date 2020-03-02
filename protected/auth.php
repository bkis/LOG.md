<?php

    $incl = get_included_files();
    if (($incl[0] == __FILE__) || empty($incl)){
        die();
    }

    require_once '../../config.php';
    $auth = false;

    if (isset($_POST['LOGMD_AUTH'])){
        if (strcmp(htmlspecialchars($_POST['LOGMD_AUTH']), LOGMD_AUTH) == 0){
            $auth = true;
        } else {
            echo '<h1>&#9785;</h1>'; // frowning emoji
            http_response_code(403);
            die();
        }
    }
    
    if (!$auth){
?>

    <style>
        #auth-form {
            width: 512px;
            max-width: 100%;
            padding: 1rem;
        }
        #auth-form input {
            height: 45px;
        }
    </style>
    
    <form id="auth-form" action="<?php echo $_SERVER['SCRIPT_NAME'] ?>" method="POST">
        <strong>Auth for </strong><?php echo $_SERVER['SCRIPT_NAME'] ?><br><br>
        <input type="password" id="auth" name="LOGMD_AUTH"/>
        <input type="submit" value="OK"/>
    </form>

    <br><br>

<?php
        // end script
        die();
    }
?>