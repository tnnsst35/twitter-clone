<?php
//http://www.php.net/manual/ja/mongo.sqltomongo.php
class MongoModel {
    private $db;
    private $dbName = "twitter";

    public  $collection;
    public  $type = "mongo";

    public function __construct() {
        $mongo = new Mongo();
        $this->db = $mongo->{$this->dbName}->{$this->collection};
    }

    public function __destruct() {
        $this->db = null;
    }

    public function save($data) {
        if (!array_key_exists("created", $data)) {
            $data["created"] = date("Y-m-d H:i:s");
        }
        if (!array_key_exists("updated", $data)) {
            $data["updated"] = date("Y-m-d H:i:s");
        }
        $this->db->insert($data);
    }

    public function update($set, $where) {
        if (!array_key_exists("updated", $set)) {
            $set["updated"]  = date("Y-m-d H:i:s");
        }
        $this->db->update($where, array('$set' => $set));
    }

    public function findAll() {
        return $this->db->find();
    }

    public function removeAll() {
        return $this->db->remove();
    }

    public function db() {
        return $this->db;
    }
}
