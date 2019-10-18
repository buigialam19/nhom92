<?php 
header('Content-Type: text/x-subrip; charset=utf-8');
if(isset($_GET['file']) && $_GET['file']){
    $file = $_GET['file'];
    $content = @file_get_contents($file);
    echo $content;
}
?>