<?php

$base = $_SERVER['REQUEST_URI'];
$base = substr($base, 0, strpos($base, '/install.php'));

$htaccess = file_get_contents('.htaccess');
echo $htaccess;