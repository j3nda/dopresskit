<?php

spl_autoload_register(function ($class) {
    $filename = str_replace('\\', DIRECTORY_SEPARATOR, $class) . '.php';

    if (is_file(__DIR__ . '/' . $filename)) {
        require_once(__DIR__ . '/' . $filename);
    }
});
