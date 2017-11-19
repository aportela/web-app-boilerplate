<?php

      declare(strict_types=1);

      namespace Foobar\Database;

      /**
       * Simple PDO Database Param Wrapper
       */
      class DBParam {

            public $name;
            public $value;
            public $type;

            /**
             * set param properties
             *
             * @param $name
             * @param $value
             * @param $type
             *
             * @return \Foobar\Database\DBParam
             */
            public function set($name, $value, $type): \Foobar\Database\DBParam {
                  $this->name = $name;
                  $this->value = $value;
                  $this->type = $type;
                  return($this);
            }

            /**
             * set NULL param
             *
             * @param $name
             *
             * @return \Foobar\Database\DBParam
             */
            public function null(string $name): \Foobar\Database\DBParam {
                  $this->name = $name;
                  $this->value = null;
                  $this->type = \PDO::PARAM_NULL;
                  return($this);
            }

            /**
             * set BOOL param
             *
             * @param $name string
             * @param $value boolean
             *
             * @return \Foobar\Database\DBParam
             */
            public function bool(string $name, bool $value): \Foobar\Database\DBParam {
                  $this->name = $name;
                  $this->value = $value;
                  $this->type = \PDO::PARAM_BOOL;
                  return($this);
            }

            /**
             * set INTEGER param
             *
             * @param $name string
             * @param $value int
             *
             * @return \Foobar\Database\DBParam
             */
            public function int(string $name, int $value): \Foobar\Database\DBParam {
                  $this->name = $name;
                  $this->value = $value;
                  $this->type = \PDO::PARAM_INT;
                  return($this);
            }

            /**
             * set FLOAT param
             *
             * @param $name string
             * @param $value int
             *
             * @return \Foobar\Database\DBParam
             */
            public function float(string $name, float $value): \Foobar\Database\DBParam {
                  $this->name = $name;
                  $this->value = $value;
                  $this->type = \PDO::PARAM_STR;
                  return($this);
            }

            /**
             * set STRING param
             *
             * @param $name string
             * @param $value int
             *
             * @return \Foobar\Database\DBParam
             */
            public function str(string $name, $value): \Foobar\Database\DBParam {
                  $this->name = $name;
                  $this->value = $value;
                  $this->type = \PDO::PARAM_STR;
                  return($this);
            }
      }

?>