<?php
// +------------------------------------------------------------------------+
// | @author        : Michael Arawole (Logad Networks)
// | @author_url    : https://www.logad.net
// | @author_email  : logadscripts@gmail.com
// | @date          : 10 Jul, 2022 11:04 AM
// +------------------------------------------------------------------------+
// | 2022 Logad Networks
// +------------------------------------------------------------------------+

// +----------------------------+
// | AutoLoader
// +----------------------------+

spl_autoload_register('synoteAutoLoader');
function synoteAutoLoader($className) {
    $path = dirname(__FILE__, 2) . "/classes/";
    $extension = ".class.php";
    $fullPath = $path . $className . $extension;

    if (file_exists($fullPath)) {
        include_once $fullPath;
    }
    return false;
}