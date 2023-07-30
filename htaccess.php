<?php

$requested_url = $_SERVER['REQUEST_URI'];

if (!file_exists($requested_url) && !is_dir($requested_url)) {
    $_GET['url'] = trim($requested_url, '/');
} else {
    return false;
}

require_once('index.php');
?>