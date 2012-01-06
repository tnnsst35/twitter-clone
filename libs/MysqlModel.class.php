<?php
function connectMySQL() {
    $host     = 'localhost';
    $database = 'twitter';
    $user     = 'twitteruser';
    $pass     = 'twitterpass';
    $dbh      = new PDO("mysql:host={$host};dbname={$database}", $user, $pass);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
    return $dbh;
}

class MysqlModel {
    private $dbh;

    public $type = "mysql";

    public function __construct() {
    }

    public function __destruct() {
        $this->dbh = null;
    }

    public function setDbh($dbh) {
        $this->dbh = $dbh;
    }

    public function begin() {
        $this->dbh->beginTransaction();
    }

    public function rollback() {
        $this->dbh->rollback();
    }

    public function commit() {
        $this->dbh->commit();
    }

    public function findOne($sql, $args) {
        if (!is_array($args)) {
            $args = (array)$args;
        }
        $state = $this->dbh->prepare($sql);
        $state->execute($args);
        return $state->fetch();
    }

    public function findAll($sql, $args) {
        if (!is_array($args)) {
            $args = (array)$args;
        }
        $state = $this->dbh->prepare($sql);
        $state->execute($args);
        return $state->fetchAll();
    }

    public function execute($sql, $args) {
        if (!is_array($args)) {
            $args = (array)$args;
        }
        $state = $this->dbh->prepare($sql);
        return $state->execute($args);
    }
}
