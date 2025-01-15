<?php

spl_autoload_register(function ($class) {
    $classPath = str_replace('\\', DIRECTORY_SEPARATOR, $class);

    $baseDir = __DIR__;

    $file = $baseDir . DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR . $classPath . '.php';

    if (file_exists($file)) {
        require_once $file;
    } else {
        throw new Exception("Nie można załadować klasy: $class. Ścieżka: $file");
    }
});