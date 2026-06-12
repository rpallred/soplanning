<?php
// Router for PHP's built-in dev server: php -S 127.0.0.1:8080 -t www dev-router.php
// Mimics www/.htaccess (clean URL -> same path + .php) and runs each script
// with the working directory set to its own folder, like Apache does.
// The require happens at the top level of this file so application scripts
// execute at global scope, exactly as under Apache/php-fpm.

$__path = urldecode(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
$__docroot = __DIR__ . '/www';
$__target = realpath($__docroot . $__path);
$__script = null;

// never serve anything that escapes the web root
if ($__target !== false && strpos($__target, $__docroot) !== 0) {
    http_response_code(404);
    echo '404 Not Found';
    return true;
}

if ($__target !== false && is_file($__target)) {
    if (substr($__target, -4) === '.php') {
        $__script = $__target;
    } else {
        return false; // static asset: let the built-in server handle it
    }
} elseif ($__target !== false && is_dir($__target) && is_file($__target . '/index.php')) {
    $__script = $__target . '/index.php';
} else {
    $__rewritten = realpath($__docroot . rtrim($__path, '/') . '.php');
    if ($__rewritten !== false && strpos($__rewritten, $__docroot) === 0 && is_file($__rewritten)) {
        $__script = $__rewritten;
    }
}

if ($__script === null) {
    http_response_code(404);
    echo '404 Not Found';
    return true;
}

chdir(dirname($__script));
$_SERVER['SCRIPT_NAME'] = substr($__script, strlen($__docroot));
$_SERVER['SCRIPT_FILENAME'] = $__script;
unset($__path, $__docroot, $__target, $__rewritten);
require $__script;
return true;
