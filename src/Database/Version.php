<?php

      declare(strict_types=1);

      namespace Foobar\Database;

      class Version {

        private $dbh;
        private $databaseType;

        private $installQueries = array(
            "PDO_SQLITE" => array(
                '
                    CREATE TABLE [VERSION] (
                        [num]	NUMERIC NOT NULL UNIQUE,
                        [date]	INTEGER NOT NULL,
                        PRIMARY KEY([num])
                    );
                ',
                '
                    INSERT INTO VERSION VALUES ("1.00", current_timestamp);
                ',
                '
                    PRAGMA journal_mode=WAL;
                '
            ),
            "PDO_MARIADB" => array(
                    '
                    CREATE TABLE `VERSION` (
                        `num`	FLOAT NOT NULL UNIQUE,
                        `date`	TIMESTAMP NOT NULL,
                        PRIMARY KEY(`num`)
                    );
                ',
                '
                    INSERT INTO `VERSION` VALUES ("1.00", utc_timestamp);
                '
            )
        );

        private $upgradeQueries = array(
            "PDO_SQLITE" => array(
            ),
            "PDO_MARIADB" => array(
            )
        );

        public function __construct (\Foobar\Database\DB $dbh, string $databaseType) {
            $this->dbh = $dbh;
            $this->databaseType = $databaseType;
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
                (new \Foobar\Database\DBParam())->str(":num", (string) $number)
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
            if (isset($this->installQueries[$this->databaseType])) {
                foreach($this->installQueries[$this->databaseType] as $query) {
                    $this->dbh->execute($query);
                }
            } else {
                throw new \Exception("Unsupported database type: " . $this->databaseType);
            }
        }

        public function upgrade() {
            if (isset($this->upgradeQueries[$this->databaseType])) {
                $result = array(
                    "successVersions" => array(),
                    "failedVersions" => array()
                );
                $actualVersion = $this->get();
                $errors = false;
                foreach($this->upgradeQueries[$this->databaseType] as $version => $queries) {
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
                            echo $e->getMessage();
                            $this->dbh->rollBack();
                            $errors = true;
                            $result["failedVersions"][] = $version;
                        }
                    } else if ($errors) {
                        $result["failedVersions"][] = $version;
                    }
                }
                return($result);
            } else {
                throw new \Exception("Unsupported database type: " . $this->databaseType);
            }
        }

        public function hasUpgradeAvailable() {
            $actualVersion = $this->get();
            $errors = false;
            foreach($this->upgradeQueries[$this->databaseType] as $version => $queries) {
                if ($version > $actualVersion) {
                    return(true);
                }
            }
            return(false);
        }

    }

?>