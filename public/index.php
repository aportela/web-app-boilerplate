<?php

    declare(strict_types=1);

    ob_start();

    require __DIR__ . '/../vendor/autoload.php';

    session_name("FOOBAR");
    session_start();

    $app = (new \Foobar\App())->get();

    $app->run();

?>