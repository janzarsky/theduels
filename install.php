<?php
$base = $_SERVER['REQUEST_URI'];
$base = substr($base, 0, strpos($base, '/install.php'));

$htaccess = file_get_contents('htaccess-template');

$htaccess = str_replace('@rewritebase', $base, $htaccess);

file_put_contents('.htaccess', $htaccess);

header('Location: ' . $base . '/install');