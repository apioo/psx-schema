<?php

require_once __DIR__ . '/../vendor/autoload.php';

\Doctrine\Common\Annotations\AnnotationRegistry::registerLoader(function ($class) {
    spl_autoload_call($class);
    return class_exists($class, false);
});
