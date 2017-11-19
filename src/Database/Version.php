<?php

      declare(strict_types=1);

      namespace Foobar\Database;

      class Version {

        private $dbh;

        private $installQueries = array(
            '
                CREATE TABLE [VERSION] (
                    [num]	NUMERIC NOT NULL UNIQUE,
                    [date]	INTEGER NOT NULL,
                    PRIMARY KEY([num])
                );
            ',
            '
                INSERT INTO VERSION VALUES (1.00, current_timestamp);
            ',
            '
                PRAGMA journal_mode=WAL;
            '
        );

        private $upgradeQueries = array();

        public function __construct (\Foobar\Database\DB $dbh) {
            $this->dbh = $dbh;
        }

        public function __destruct() { }

        public function get() {
            $query = ' SELECT num FROM VERSION ORDER BY num DESC LIMIT 1; ';
            $results = $this->dbh->query($query, array());
            if ($results && count($results) == 1) {
                return($results[0]->num);
            } else {
                throw new \Foobar\Exception\NotFoundException("invalid database version");
            }
        }

        private function set(float $number) {
            $params = array(
                (new \Foobar\Database\DBParam())->float(":num", $number)
            );
            $query = '
                INSERT INTO VERSION
                    (num, date)
                VALUES
                    (:num, current_timestamp);
            ';
            return($this->dbh->execute($query, $params));
        }

        public function install() {
            foreach($this->installQueries as $query) {
                $this->dbh->execute($query);
            }
        }

        public function upgrade() {
            $result = array(
                "successVersions" => array(),
                "failedVersions" => array()
            );
            $actualVersion = $this->get();
            $errors = false;
            foreach($this->upgradeQueries as $version => $queries) {
                if (! $errors && $version > $actualVersion) {
                    try {
                        $this->dbh->beginTransaction();
                        foreach($queries as $query) {
                            $this->dbh->execute($query);
                        }
                        $this->set(floatval($version));
                        $this->dbh->commit();
                        $result["successVersions"][] = $version;
                    } catch (\PDOException $e) {
                        $this->dbh->rollBack();
                        $errors = true;
                        $result["failedVersions"][] = $version;
                    }
                } else if ($errors) {
                    $result["failedVersions"][] = $version;
                }
            }
            return($result);
        }

    }

?>