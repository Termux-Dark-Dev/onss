<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $link = './user/folder/' . $_POST["link"];
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename="study.pdf"'); // Set the desired filename for download
    header('Content-length:' . filesize($link));
    readfile($link);
        exit; // Terminate further exe  
} else {
    // Redirect to notes.php
    header('Location: notes.php');
    exit;
}
?>