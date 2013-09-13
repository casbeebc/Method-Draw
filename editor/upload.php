<?php

$uploaddir = getcwd().'/uploads/';
$uploadfile = $uploaddir . basename($_FILES['file']['name']);

if (move_uploaded_file($_FILES['file']['tmp_name'], $uploadfile)) {
    header("HTTP/1.1 200 OK");
} else {
    header("HTTP/1.1 500 Internal Server Error");
}

?>