<?php

require_once('DBfunction.php');

function serch(){
    //前処理
    $subject = $_POST['subject'];
    $text = $_POST['text'];

    $subject = substr($subject, 0, strpos($subject, ','));
    $text = substr($text, 0, strpos($text, ','));

    if($subject = )
}


?>