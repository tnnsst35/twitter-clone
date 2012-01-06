<?php
class User extends MysqlModel {
    public function save($data) {
        $sql = "INSERT INTO users (username, nickname, email, password, created, updated) VALUES (?, ?, ?, ?, NOW(), NOW())";
        return $this->execute($sql, array(
                    $data["username"],
                    $data["nickname"],
                    $data["email"],
                    $data["password"],
                    ));
    }

    public function findById($id) {
        $sql = "SELECT * FROM users WHERE id = ? LIMIT 1";
        return $this->findOne($sql, $id);
    }

    public function findByUsername($username) {
        $sql = "SELECT * FROM users WHERE username = ? LIMIT 1";
        return $this->findOne($sql, $username);
    }

    public function countByUsername($username) {
        $sql = "SELECT COUNT(*) AS num FROM users WHERE username = ?";
        $res = $this->findOne($sql, $username);
        return $res ? (int)$res["num"] : null;
    }

    public function findByKeyword($keyword, $limit) {
        $sql = "SELECT * FROM users WHERE username LIKE ? OR nickname LIKE ? LIMIT {$limit}";
        return $this->findAll($sql, array("%{$keyword}%", "%{$keyword}%"));
    }

    public function countByEmail($email) {
        $sql = "SELECT COUNT(*) AS num FROM users WHERE email = ?";
        $res = $this->findOne($sql, $email);
        return $res ? (int)$res["num"] : null;
    }
}

/*
class User extends Model {
    public $collection = "users";
    public $fields = array(
            "username",
            "nickname",
            "email",
            "password",
            "private_mode",
            "created",
            "updated",
            );

    public function countByUsername($username) {
        return $this->db()->find(array("username" => $username))->count();
    }

    public function findByUsername($username) {
        return $this->db()->findOne(array("username" => $username));
    }

    public function findById($id) {
        return $this->db()->findOne(array("_id" => $id));
    }

    public function findByKeyword($keyword, $limit) {
        return $this->db()->find(array('$or' => array(array("username" => new MongoRegex("/{$keyword}/")), array("nickname" => new MongoRegex("/{$keyword}/")))))->limit($limit);
    }
}
*/
