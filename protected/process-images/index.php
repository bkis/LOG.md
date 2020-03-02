<?php

    //auth
    include '../auth.php';

    //// PROCESS IMAGES

    // load config
    require_once '../../config.php';

    // define image extensions to look for
    $display = ['jpg', 'jpeg', 'png'];

    // array for image files
    $images = [];
    
    // traverse posts directory to find image files
    $it = new RecursiveDirectoryIterator('../../' . LOGMD_POSTS_DIRECTORY);
    foreach(new RecursiveIteratorIterator($it) as $file) {
        $ex = explode('.', $file);
        if (in_array(strtolower(array_pop($ex)), $display)) {
            $images[] = $file;
        }
    }

?>

    <h1>LOG.md</h1>
    <h2>Resizing <?php echo sizeof($images) ?> images...</h2>
    <strong>This will ONLY change JPG, JPEG and PNG images!</strong><br/>
    <br/>
    <strong>Resizing to width: </strong><?php echo LOGMD_IMAGE_RESIZE_WIDTH ?> pixels<br/>
    <strong>Saving JPG and JPEG with quality: </strong><?php echo LOGMD_IMAGE_RESIZE_QUALITY_JPG ?><br/>
    <strong>Saving PNG with quality: </strong><?php echo LOGMD_IMAGE_RESIZE_QUALITY_PNG ?><br/>
    <br/>

<?php

    // scale images to max width set in config
    include '../../lib/ImageResize.php';
    use \Gumlet\ImageResize;

    foreach ($images as $imagePath) {
        echo 'PROCESSING: ' . $imagePath . ' ... ';
        list($width) = getimagesize($imagePath);
        if ($width <= LOGMD_IMAGE_RESIZE_WIDTH){
            echo 'already ' . $width . ' pixels wide<br/>';
            continue;
        }
        $image = new \Gumlet\ImageResize($imagePath);
        $image->resizeToWidth(LOGMD_IMAGE_RESIZE_WIDTH);
        $image->save($imagePath . '_resized');
        rename($imagePath, $imagePath . '_original');
        rename($imagePath . '_resized', $imagePath);
        echo 'resized from ' . $width . ' to ' . LOGMD_IMAGE_RESIZE_WIDTH . ' pixels width<br/>';
    }

?>