<?php

class PersistanceManager {

    private $pdo;
    private $dbHost = 'localhost';
    private $dbUserName = 'root';
    private $dbPassword = 'qwe123!@#';
    private $dbName = 'insert_sql_test';

    public function __construct() {
        try {
            $this->pdo = new PDO("mysql:host=$this->dbHost;dbname=$this->dbName", $this->dbUserName, $this->dbPassword);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function getCount($query, $param = null) {
        $result = $this->executeQuery($query, $param, true);

        return $result['c'];
    }

    public function run($query, $param = null, $fetchFirstRecOnly = false) {
        $result = $this->executeQuery($query, $param, $fetchFirstRecOnly);

        return $result;
    }

    public function num_row($query) {
        $result = $this->pdo->prepare($query);
        $result->execute();
        $rows = $result->rowCount();
        //  $rows = $result->fetch(PDO::FETCH_ASSOC);
        return $rows;
    }

    public function run_other($query) {
        $this->pdo->exec($query);
    }

    public function insertAndGetLastRowId($query, $param = null) {
        $result = $this->executeQuery($query, $param, true, true);
        return $result;
    }

    private function executeQuery($query, $param = null, $fetchFirstRecOnly = false, $getLastInsertedId = false) {
        try {
            $stmt = $this->pdo->prepare($query);
            $stmt->execute($param);
            if ($getLastInsertedId) {
                return $this->pdo->lastInsertId();
            }
            if (strtoupper(substr(trim($query), 0, 6)) == "SELECT") {
                if ($fetchFirstRecOnly)
                    $result = $stmt->fetch(PDO::FETCH_ASSOC);
                else
                    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                $stmt->closeCursor();
                return $result;
            }
            $stmt->closeCursor();
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

}

?>