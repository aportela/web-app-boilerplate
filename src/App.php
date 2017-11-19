<?php
    declare(strict_types=1);

    namespace Foobar;

    class App {
        private $app;

        public function __construct() {
            $settings = require __DIR__ . '/../src/AppSettings.php';
            $this->app = new \Slim\App($settings);
            require 'AppDependencies.php';
            require 'AppRoutes.php';
        }

        public function get() {
            return ($this->app);
        }
    }
?>