<?php

    declare(strict_types=1);

    namespace Foobar\Test;

    require_once dirname(dirname(__DIR__)) . DIRECTORY_SEPARATOR . "vendor" . DIRECTORY_SEPARATOR . "autoload.php";

    final class AppRoutesTest extends APITest
    {
        /**
         * Called once just like normal constructor
         */
        public static function setUpBeforeClass (): void { }

        /**
         * Clean up the whole test class
         */
        public static function tearDownAfterClass(): void { }

        /**
         * Initialize the test case
         * Called for every defined test
         */
        protected function setUp(): void { }

        /**
         * Clean up the test case, called for every defined test
         */
        protected function tearDown(): void { }

        public function testRootPath(): void {
            $this->request('GET', "/");
            $this->assertThatResponseHasStatus(200);
        }

        public function testPoll(): void {
            $this->request('GET', "/api/poll");
            $this->assertThatResponseHasStatus(200);
            $this->assertThatResponseHasContentType("application/json");
        }
    }
?>