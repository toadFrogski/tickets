<?php

spl_autoload_register(function ($class) {
    // Define the base directory for the root namespace
    $base_dir = __DIR__ . '/';

    // Replace namespace separators with directory separators
    $file = $base_dir . str_replace('\\', '/', $class) . '.php';

    if (file_exists($file)) {
        require_once $file;
    }
});
