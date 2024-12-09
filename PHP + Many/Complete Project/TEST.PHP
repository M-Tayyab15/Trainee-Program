<?php
// Check current values of post_max_size and upload_max_filesize
$post_max_size = ini_get('post_max_size');
$upload_max_filesize = ini_get('upload_max_filesize');

echo "Current post_max_size: " . $post_max_size . "<br>";
echo "Current upload_max_filesize: " . $upload_max_filesize . "<br>";

// Note: You cannot set these values here, but you can inform users to change them in php.ini
?>